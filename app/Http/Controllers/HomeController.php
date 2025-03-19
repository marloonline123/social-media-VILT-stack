<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index() {
        $posts = Post::with('user', 'attachments','likes')->latest()->paginate(10);
        Log::info('Liked post: ', [$posts]);
        return inertia('Home', [
            'posts' => PostResource::collection($posts)
        ]);
    }
}
