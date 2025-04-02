<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class PageResource extends JsonResource
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
            'user_id' => $this->user_id,
            'username' => $this->username,
            'about' => $this->about,
            'avatar' => $this->avatar ? asset('storage/' . $this->avatar) : asset('images/page-avatar.jpg'),
            'cover' => $this->cover ? asset('storage/' . $this->cover) : asset('images/page-cover.jpg'),
            'is_admin' => Auth::id() == $this->user_id,
            'user' => new UserResource($this->user),
            'isFollowing' => $this->followers()->where('follower_id', Auth::id())->exists(),
            'followers_count' => $this->followers()->count(),
            'posts_count' => $this->posts()->count(),
            'created_at' => Carbon::parse($this->created_at)->diffForHumans(),
        ];
    }
}
