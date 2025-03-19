<?php

namespace App\Jobs;

use App\Models\Post;
use App\Models\PostAttachment;
use App\Services\FileService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UploadPostAttachments implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    protected $post;
    protected $filePath;

    /**
     * Create a new job instance.
     */
    public function __construct(Post $post, string $filePath)
    {
        $this->post = $post;
        $this->filePath = str_replace('/', '\\', ($filePath));
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Processing file upload in background for Post ID: ' . $this->post->id);
        

        // Ensure the file exists in storage
        // if (!str_replace('/', '\\', Storage::disk('temp')->exists($this->filePath))) {
        // if (!Storage::exists($this->filePath)) {
        //     Log::error('File not found in storage: ' . Storage::disk('temp')->path($this->filePath));
        //     return;
        // }

        // Get file content and move it to permanent storage
        // $file = Storage::disk('temp')->path($this->filePath);
        $file = file_get_contents($this->filePath);

        $path = FileService::uploadFile($file, 'posts/attachments', 'public', true, [
            'crop' => true,
            'width' => 1080,
            'ratioX' => 5,
            'ratioY' => 3.5
        ]);

        $filename = basename($path);
        $mime = mime_content_type($file); // Correctly get the MIME type

        // Store file details in database
        PostAttachment::create([
            'name' => $filename,
            'post_id' => $this->post->id,
            'path' => $path,
            'mime' => $mime,
            'type' => $mime,
            'created_by' => Auth::id(),
        ]);

        // Delete temp file after processing
        Storage::disk('temp')->delete($this->filePath);

        Log::info('File upload completed for Post ID: ' . $this->post->id);
    }
}
