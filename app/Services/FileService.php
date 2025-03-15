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
    private static function optimizeVideo($file, $path, $filename, $disk)
    {
        $originalPath = Storage::disk($disk)->putFileAs($path, $file, 'original_' . $filename);
        $optimizedFilename = 'optimized_' . $filename;
        $optimizedPath = storage_path("app/$disk/$path/$optimizedFilename");

        // Compress video using FFmpeg
        $command = "ffmpeg -i " . storage_path("app/$disk/$originalPath") . " -vcodec libx264 -crf 28 -preset fast " . $optimizedPath;
        exec($command);

        // Delete the original file
        Storage::disk($disk)->delete($originalPath);

        return "$path/$optimizedFilename";
    }
}
