<?php

namespace App\Http\Controllers;

use App\Http\Requests\Posts\PostRequest;
use App\Models\BaseModel;
use App\Models\Post;
use App\Models\PostAttachment;
use App\Services\FileService;
use Faker\Provider\Base;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\ImageManager;
use Spatie\ImageOptimizer\OptimizerChain;
use Spatie\ImageOptimizer\Optimizers\Gifsicle;
use Spatie\ImageOptimizer\Optimizers\Jpegoptim;
use Spatie\ImageOptimizer\Optimizers\Optipng;
use Spatie\ImageOptimizer\Optimizers\Pngquant;

class PostController extends Controller
{
    
    public function index()
    {
        //
    }

    public function store(PostRequest $request)
    {
        // $body = strip_tags($request->body);
        // dd($request->all(), $body);
        Gate::authorize('create', Post::class);
        
        $post = Post::create([
            'body' => $request->body,
            'user_id' => Auth::id(),
            'slug' => BaseModel::generateRandomCharachters('P')
        ]);

        if ($request->attachments) {
            $this->uploadAttachment($post, $request->attachments);
        }

        return back();
    }

    public function show(string $id)
    {
        //j
    }

    public function update(Request $request, Post $post)
    {
        Gate::authorize('update', $post);

        $post->update([
            'body' => $request->body,
        ]);

        if ($request->attachments) {
            $this->uploadAttachment($post, $request->attachments);
        }

        if ($request->removedAttachments) {
            $this->removeAttachments($request->removedAttachments);
        }

        $post->refresh();
        return back();
    }

    public function destroy(string $id)
    {
        Post::destroy($id);

        return back();
    }

    private function uploadAttachment($post, $attachments)
    {
        foreach ($attachments as $attachment) {
            $file = $attachment;
            $path = FileService::uploadFile($file, 'posts/attachments', 'public', true, ['crop' => true, 'width' => 1080, 'ratioX' => 5, 'ratioY' => 3.5]);
            $filename = str_replace('posts/attachments/', '', $path);
            $mime = $file->getClientMimeType();

            PostAttachment::create([
                'name' => $filename,
                'post_id' => $post->id,
                'path' => $path,
                'mime' => $mime,
                'type' => $mime,
                'created_by' => Auth::id(),
            ]);
        }
    }

    private function removeAttachments($attachments) {
        foreach ($attachments as $attachment) {
            Log::info('Deleting attachment', [$attachment]);
            FileService::deleteFile($attachment['path']);
            PostAttachment::find($attachment['id'])->delete();
        }
    }
}
