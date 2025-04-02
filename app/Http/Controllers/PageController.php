<?php

namespace App\Http\Controllers;

use App\Http\Requests\PageRequest;
use App\Http\Resources\PageResource;
use App\Http\Resources\PostAttachmentResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Models\Page;
use App\Models\Post;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function posts(Request $request, string $id)
    {
        $offset = $request->offset ?? 0;
        $posts = Post::with('user', 'postable', 'attachments', 'comments.user')->where('postable_type', 'App\Models\Page')->where('postable_id', $id)->latest()->take(10)->offset($offset)->get();
        return response()->json(['posts' => PostResource::collection($posts)]);
    }
    
    public function store(PageRequest $request)
    {
        Gate::authorize('create', Page::class);
        $username = $this->generateUsername($request->name);
        $data = array_merge($request->validated(), ['username' => $username, 'user_id' => Auth::id()]);
        $page = Page::create($data);
        $page->followers()->create(['follower_id' => Auth::id()]);
        return redirect()->route('pages.show', $page->username);
    }

    public function show(string $username)
    {
        $page = Page::with([
            'user',
            'followers',
            'attachments',
        ])->where('username', $username)->firstOrFail();

        return inertia('ThePage', [
            'page' => new PageResource($page),
            'followers' => UserResource::collection($page->followers->map(fn($follower) => $follower->follower)),
            'attachments' => PostAttachmentResource::collection($page->attachments),
        ]);
    }

    public function update(PageRequest $request, Page $page)
    {
        Gate::authorize('update', $page);
        $page->update($request->validated());
        return back();
    }

    public function destroy(Page $page)
    {
        Gate::authorize('update', $page);
        $page->delete();
        return redirect()->route('home');
    }

    public function followToggle(Request $request, Page $page)
    {
        // Gate::authorize('follow-toggle', $page);
        Log::info('Attempting to follow/unfollow page', [$page]);
        try {
            if ($page->isFollowing()) {
                $page->followers()->where('follower_id', Auth::id())->delete();
            } else {
                $page->followers()->create(['follower_id' => Auth::id()]);
            }
            Log::info('Successfully followed/unfollowed page');
        } catch (\Exception $e) {
            Log::error('Error following/unfollowing page: ' . $e->getMessage());
        }
        

        return back();
    }

    public function uploadAvatar(Request $request, Page $page)
    {
        Gate::authorize('update', $page);
        $request->validate([
            'avatar' => ['required', 'image', 'max:10240'],
        ]);
        $avatar = FileService::uploadFile($request->file('avatar'), 'pages/avatars', crop: ['crop' => true, 'width' => 500, 'ratioX' => 1, 'ratioY' => 1]);
        $page->update(['avatar' => $avatar]);

        return back();
    }

    public function uploadCover(Request $request, Page $page)
    {
        Gate::authorize('update', $page);
        $request->validate([
            'cover' => ['required', 'image', 'max:10240'],
        ]);
        $cover = FileService::uploadFile($request->file('cover'), 'pages/covers', crop: ['crop' => true, 'width' => 1080, 'ratioX' => 4, 'ratioY' => 1]);
        $page->update(['cover' => $cover]);

        return back();
    }

    private function generateUsername($name)
    {
        $username = Str::slug($name);
        if (Page::where('username', $username)->exists()) {
            $this->generateUsername($username . '_' . Str::random(3));
        }
        return $username;
    }
}
