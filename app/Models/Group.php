<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Auth;

class Group extends Model
{
    protected $fillable = ['name', 'slug', 'about', 'cover', 'avatar', 'auto_approval', 'user_id', 'deleted_by'];

    protected $casts = [
        'auto_approval' => 'boolean'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function posts(): MorphMany
    {
        return $this->morphMany(Post::class, 'postable');
    }

    public function attachments(): HasManyThrough
    {
        return $this->hasManyThrough(PostAttachment::class, Post::class, 'postable_id', 'post_id');
    }

    public function members(): HasMany
    {
        return $this->hasMany(GroupUser::class, 'group_id');
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(GroupUserInvitation::class, 'group_id');
    }
}
