<?php

namespace App\Http\Controllers;

use App\Http\Requests\Posts\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\BaseModel;
use App\Models\Post;
use App\Models\PostAttachment;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{

    public function index(Request $request)
    {
        $offset = $request->offset ?? 0;
        $posts = Post::with('user', 'attachments', 'likes', 'comments.user')->latest()->take(10)->offset($offset)->get();
        return response()->json(['posts' => PostResource::collection($posts)]);
    }

    public function store(PostRequest $request)
    {
        Gate::authorize('create', Post::class);
        
        $post = Post::create([
            'body' => $request->body,
            'user_id' => Auth::id(),
            'slug' => BaseModel::generateRandomCharachters('P')
        ]);

        if ($request->attachments) {
            $this->uploadAttachment($post, $request->attachments);
        }

        return response()->json(['post' => new PostResource($post)]);
    }

    public function show(string $id)
    {
        //j
    }

    public function update(PostRequest $request, Post $post)
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

        return response()->json(['post' => new PostResource($post)]);
    }

    public function likePost(Post $post) {
        Gate::authorize('like', $post);

        if ($post->likes()->where('user_id', Auth::id())->exists()) {
            $post->likes()->where('user_id', Auth::id())->delete();
            return response()->json(['liked' => false]);
        }
        $post->likes()->create([
            'user_id' => Auth::id(),
        ]);

        return response()->json(['liked' => true]);
    }

    public function destroy(string $id)
    {
        $status = Post::destroy($id);

        return response()->json(['status' => $status]);
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
        $attachments = json_decode($attachments, true);
        Log::info('Removing attachments are: ', [$attachments]);
        foreach ($attachments as $attachment) {
            Log::info('Deleting attachment', [$attachment]);
            FileService::deleteFile($attachment['path']);
            PostAttachment::find($attachment['id'])->delete();
        }
    }
}
