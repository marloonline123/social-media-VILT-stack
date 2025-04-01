<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupUserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->user->id,
            'name' => $this->user->name,
            'username' => $this->user->username,
            'avatar' => $this->user->avatar ? asset('storage/' . $this->user->avatar) : asset('images/user-avatar.jpg'),
            'cover' => $this->user->cover ? asset('storage/' . $this->user->cover) : asset('images/user-cover.jpg'),
            'role' => $this->role,
            'group' => new GroupResource($this->group),
        ];
    }
}
