<?php

namespace App\Http\Controllers;

use App\Models\BaseModel;
use App\Models\Post;
use App\Models\PostAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $attachments = [];
        
        $post = Post::create([
            'body' => $request->body,
            'user_id' => Auth::id(),
            'slug' => $this->generateSlug()
        ]);

        if ($request->attachments) {
            foreach ($request->attachments as $attachment) {
                PostAttachment::create([
                    'name' => $attachment->getClientOriginalName(),
                    'post_id' => $post->id,
                    'path' => BaseModel::uploadFile($attachment, 'posts/attachments'),
                    'mime' => $attachment->getClientMimeType(),
                    'type' => $attachment->getClientMimeType(),
                    'created_by' => Auth::id(),
                ]);
            }
        }

        return back();
    }

    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $post = Post::findOrFail($id);
        $post->update([
            'body' => $request->body,
        ]);

        $post->refresh();
        return back();
    }

    public function destroy(string $id)
    {
        Post::destroy($id);

        return back();
    }


    public function generateSlug()
    {
        return 'P' . strtoupper(substr(bin2hex(random_bytes(8)), 0, 14));
    }
}
