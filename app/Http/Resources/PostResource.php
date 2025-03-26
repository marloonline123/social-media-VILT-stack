<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'slug' => $this->slug,
            'user' => $this->user,
            'group' => $this->group,
            'liked' => $this->likes()->where('user_id', Auth::id())->exists(),
            'likes_count' => $this->likes()->count(),
            'comments_count' => $this->comments()->count(),
            'comments' => CommentResource::collection($this->comments()->take(3)->get()),
            'attachments' => PostAttachmentResource::collection($this->attachments),
            'created_at' => Carbon::parse($this->created_at)->lessThan(Carbon::now()->subDays(7))
                ? Carbon::parse($this->created_at)->format('Y-m-d h:i A')
                : Carbon::parse($this->created_at)->diffForHumans(),

        ];
    }
}
