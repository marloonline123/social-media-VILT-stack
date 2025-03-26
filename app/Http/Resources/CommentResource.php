<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class CommentResource extends JsonResource
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
            'body' => $this->body,
            'user' => $this->user,
            'post' => [
                'id' => $this->post->id,
                'slug' => $this->post->slug,
            ],
            'comment_id' => $this->comment_id,
            'liked' => $this->likes()->where('user_id', Auth::id())->exists(),
            'likes_count' => $this->likes()->count(),
            'replies_count' => $this->replies()->count(),
            'replies' => CommentResource::collection($this->replies),
            'created_at' => Carbon::parse($this->created_at)->diffForHumans(),
        ];
    }
}
