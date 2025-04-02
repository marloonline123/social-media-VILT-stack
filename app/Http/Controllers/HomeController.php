<?php

namespace App\Http\Controllers;

use App\Http\Resources\GroupResource;
use App\Http\Resources\PageResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Models\Group;
use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index() {
        $groups = Group::with('user', 'members')->latest()->take(5)->get();
        $followers = Auth::user()?->followers()->latest()->take(5)->get() ?? [];
        $pages = Page::with('user', 'followers', 'posts')
            ->whereHas('followers', function ($query) {
                $query->where('follower_id', Auth::id());
            })
            ->latest()->take(5)->get();
        
        return inertia('Home', [
            'groups' => GroupResource::collection($groups),
            'followers' => UserResource::collection($followers),
            'pages' => PageResource::collection($pages),
        ]);
    }
}
