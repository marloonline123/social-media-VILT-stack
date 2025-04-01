<?php

namespace App\Http\Resources;

use App\Models\Group;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class GroupResource extends JsonResource
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
            'slug' => $this->slug,
            'about' => $this->about,
            'avatar' => $this->avatar ? asset('storage/' . $this->avatar) : asset('images/group-avatar.jpg'),
            'cover' => $this->cover ? asset('storage/' . $this->cover) : asset('images/group-cover.jpg'),
            'auto_approval' => $this->auto_approval,
            'is_admin' => Auth::id() == $this->user_id || $this->members()->where('user_id', Auth::id())->where('role', 'admin')->exists() ? true : false,
            'joined' => $this->members()->where('user_id', Auth::id())->exists() ? true : false,
            'status' => $this->members()->firstWhere('user_id', Auth::id())?->status ?? null,
            // 'user' => new UserResource($this->user),
            'invited' => $this->invitations()->where('status', 'pending')->where('user_id', Auth::id())->exists() ? true : false,
            'created_at' => Carbon::parse($this->created_at)->diffForHumans(),
        ];
    }
}
