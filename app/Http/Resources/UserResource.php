<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'avatar' => $this->avatar ? asset('storage/' . $this->avatar) : asset('images/user-avatar.jpg'),
            'cover' => $this->cover_image ? asset('storage/' . $this->cover_image) : asset('images/user-cover.jpg'),
            'bio' => $this->bio,
            'isFollowing' => $this->isFollowing(Auth::id()),
            'gender' => $this->gender,
            'likes_count' => $this->likes()->count(),
            'followers_count' => $this->followers()->count(),
            'followings_count' => $this->followings()->count(),
            'posts_count' => $this->posts()->count(),
        ];
    }
}
