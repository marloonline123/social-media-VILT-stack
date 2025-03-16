<?php

namespace App\Services;

use App\Models\BaseModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class FileService
{
    /**
     * Upload a file with optional image optimization and cropping.
     */
    public static function uploadFile($file, $path, $disk = 'public', $optimize = true, $crop = ['crop' => true, 'width' => 1080, 'ratioX' => 5, 'ratioY' => 3])
    {
        $mime = $file->getClientMimeType();
        $extension = strtolower($file->getClientOriginalExtension());
        $filename = BaseModel::generateRandomCharachters('FILE', 20) . '.' . $extension;
        $storagePath = "$path/$filename";

        if (str_starts_with($mime, 'image/') && $optimize) {
            return self::optimizeImage($file, $path, $filename, $disk, $crop);
        } elseif (str_starts_with($mime, 'video/')) {
            return self::optimizeVideo($file, $path, $filename, $disk);
        } else {
            // Save file as-is
            Storage::disk($disk)->putFileAs($path, $file, $filename);
            return $storagePath;
        }
    }

    /**
     * Delete a file.
     */
    public static function deleteFile($path, $disk = 'public')
    {
        return Storage::disk($disk)->delete($path);
    }

    /**
     * Optimize an image with optional cropping.
     */
    private static function optimizeImage($file, $path, $filename, $disk, $crop)
    {
        $extension = strtolower($file->getClientOriginalExtension());
        if ($extension === 'gif') {
            return self::processGif($file, $path, $filename, $disk, $crop);
        }

        $image = Image::read($file);

        if ($crop['crop']) {
            $width = $crop['width'];
            $ratioX = $crop['ratioX'];
            $ratioY = $crop['ratioY'];
            $image = self::cropImage($image, $width, $ratioX, $ratioY);
        }

        switch ($extension) {
            case 'avif':
                $optimizedImage = $image->toAvif();
                break;
            default:
                $optimizedImage = $image->toWebp(80);
                break;
        }
        Storage::disk($disk)->put("$path/$filename", $optimizedImage);
        return "$path/$filename";
    }

    private static function cropImage($image, $width = 1080, $ratioX = 5, $ratioY = 3)
    {
        $targetHeight = intval($width * $ratioY / $ratioX);
        return $image->cover($width, $targetHeight);
    }

    /**
     * Crop & Optimize Animated GIF
     */
    private static function processGif($file, $path, $filename, $disk, $crop)
    {
        $originalPath = $file->getPathname();
        $optimizedPath = storage_path("app/temp_optimized.gif");

        // Crop and optimize GIF directly using gifsicle
        $crop['height'] = intval($crop['width'] * $crop['ratioY'] / $crop['ratioX']);
        $command = "gifsicle --crop {$crop['ratioX']},{$crop['ratioY']}+{$crop['width']}x{$crop['height']} -O3 "
            . escapeshellarg($originalPath) . " -o " . escapeshellarg($optimizedPath);

        exec($command, $output, $returnCode);

        if ($returnCode !== 0) {
            Log::error("GIF processing failed", ['output' => $output, 'command' => $command]);
            return null;
        }

        // Store the optimized GIF
        Storage::disk($disk)->putFileAs($path, new \Illuminate\Http\File($optimizedPath), $filename);

        return "$path/$filename";
    }


    /**
     * Optimize a video using FFmpeg.
     */
    private static function optimizeVideo($file, $path, $filename, $disk = 'public')
    {
        try {
            Log::info("Starting video optimization for: $filename");

            // Ensure directory exists
            Storage::disk($disk)->makeDirectory($path);

            // Save the original video in public storage
            $originalFilename = 'original_' . $filename;
            $originalPath = Storage::disk($disk)->putFileAs($path, $file, $originalFilename);
            $originalFullPath = Storage::disk($disk)->path($originalPath);

            if (!$originalPath || !Storage::disk($disk)->exists($originalPath)) {
                Log::error("Failed to upload original video: $originalFullPath");
                return null;
            }
            Log::info("Original video stored at: $originalFullPath");

            // Set optimized file path
            $optimizedFilename = pathinfo($filename, PATHINFO_FILENAME) . "_optimized.mp4";
            $optimizedPath = Storage::disk($disk)->path("$path/$optimizedFilename");
            Log::info("Optimized video path: $optimizedPath");

            // Construct FFmpeg command
            $command = "ffmpeg -i " . escapeshellarg($originalFullPath) .
                " -vcodec libx264 -crf 28 -preset fast -movflags +faststart " .
                escapeshellarg($optimizedPath);

            Log::info("Executing FFmpeg command: $command");

            exec($command, $output, $returnCode);

            // Log FFmpeg output
            Log::info("FFmpeg output:", $output);

            if ($returnCode !== 0) {
                Log::error("FFmpeg failed with return code: $returnCode", ['output' => $output]);
                return null;
            }

            // Check if optimized video was created
            if (!file_exists($optimizedPath)) {
                Log::error("Optimized video not created: $optimizedPath");
                return null;
            }

            Log::info("Video successfully optimized and stored at: $optimizedPath");

            // Delete original video after successful optimization
            Storage::disk($disk)->delete($originalPath);
            Log::info("Deleted original video: $originalFullPath");

            return "$path/$optimizedFilename";
        } catch (\Exception $e) {
            Log::error("Video optimization error: " . $e->getMessage());
            return null;
        }
    }
}
