<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\PostAttachmentResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Models\BaseModel;
use App\Models\User;
use App\Services\FileService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    
    public function show(Request $request, string $username): Response
    {
        $user = User::with('posts')->where('username', $username)->firstOrFail();
        Gate::authorize('view', $user);
        return Inertia::render('Profile/Show', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'user' => new UserResource($user),
            'followers' => UserResource::collection($user->followers),
            'followings' => UserResource::collection($user->followings),
            'attachments' => PostAttachmentResource::collection($user->attachments),
        ]);
    }
    
    public function posts(Request $request, string $username)
    {
        $offset = $request->offset ?? 0;
        $user = User::with('posts')->where('username', $username)->firstOrFail();
        return response()->json([
            'posts' => PostResource::collection($user->posts()->latest()->take(10)->offset($offset)->get())
        ]);
    }
    
    public function followToggle(Request $request, string $username)
    {
        $user = User::where('username', $username)->firstOrFail();
        Gate::authorize('follow-toggle', $user);
        if ($user->isFollowing(Auth::id())) {
            $user->followers()->detach(Auth::id());
        } else {
            $user->followers()->attach(Auth::id());
        }

        return back();
    }
    
    public function edit(Request $request): Response
    {
        Log::info('user resource', [new UserResource($request->user())]);
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'user' => new UserResource($request->user()),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        Gate::authorize('view', $request->user());
        $request->user()->fill($request->validated());

        if ($request->hasFile('avatar')) {
            $request->validate([
                'avatar' => ['image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
            ]);
            $request->user()->avatar = FileService::uploadFile($request->file('avatar'), 'avatars', crop: ['crop' => true, 'width' => 500, 'ratioX' => 1, 'ratioY' => 1]);
        }

        if ($request->hasFile('cover_image')) {
            $request->validate([
                'cover_image' => ['image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
            ]);
            $request->user()->cover_image = FileService::uploadFile($request->file('cover_image'), 'cover_images', crop: ['crop' => true, 'width' => 1080, 'ratioX' => 4, 'ratioY' => 1]);
        }

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit', $request->user()->username)->with('status', 'profile-information-updated');
    }
    
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Gate::authorize('delete', $user);

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
