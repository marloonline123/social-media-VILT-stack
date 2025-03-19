<?php

namespace App\Http\Resources;

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
            'attachments' => PostAttachmentResource::collection($this->attachments),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
