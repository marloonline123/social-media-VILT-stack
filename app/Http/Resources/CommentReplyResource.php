<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class CommentReplyResource extends JsonResource
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
            'post' => PostResource::make($this->post),
            'comment' => CommentResource::make($this->comment),
            'liked' => $this->likes()->where('user_id', Auth::id())->exists(),
            'likes_count' => $this->likes()->count(),
            'created_at' => Carbon::parse($this->created_at)->diffForHumans(),
        ];
    }
}
