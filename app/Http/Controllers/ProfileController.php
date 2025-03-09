<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\BaseModel;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    
    public function show(Request $request, string $username): Response
    {
        $user = User::where('username', $username)->firstOrFail();
        return Inertia::render('Profile/Show', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'user' => $user,
        ]);
    }
    
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        
        $request->user()->fill($request->validated());

        if ($request->hasFile('avatar')) {
            $request->validate([
                'avatar' => ['image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
            ]);
            $request->user()->avatar = BaseModel::uploadFile($request->file('avatar'), 'avatars');
        }

        if ($request->hasFile('cover_image')) {
            $request->validate([
                'cover_image' => ['image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
            ]);
            $request->user()->cover_image = BaseModel::uploadFile($request->file('cover_image'), 'cover_images');
        }

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit', $request->user()->username)->with('status', 'profile-information-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
