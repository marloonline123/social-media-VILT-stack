<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $posts = Post::with('user', 'attachments')->latest()->paginate(10);
        return inertia('Home', [
            'posts' => PostResource::collection($posts)
        ]);
    }
}
