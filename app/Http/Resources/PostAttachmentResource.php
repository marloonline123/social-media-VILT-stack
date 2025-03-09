<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostAttachmentResource extends JsonResource
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
            'preview' => url('/storage\/') . $this->path,
            'mime' => $this->mime,
            'type' => $this->mime,
            'post_id' => $this->post_id,
            'created_by' => $this->created_by
        ];
    }
}
