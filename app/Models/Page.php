<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;

class Page extends Model
{
    protected $fillable = ['name', 'username', 'about', 'cover', 'avatar', 'user_id', 'deleted_by'];

    public function isFollowing()
    {
        return $this->followers()->where('follower_id', Auth::id())->exists();
    }

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

    public function followers(): HasMany
    {
        return $this->hasMany(PageFollowers::class, 'page_id');
    }
}
