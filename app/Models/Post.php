<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Post extends Model
{
    protected $fillable = ['body', 'slug', 'user_id', 'postable_id', 'postable_type', 'isDisabled'];

    protected $casts = [
        'isDisabled' => 'boolean'
    ];

    public function scopeActive($query) {
        return $query->where('isDisabled', 0);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function postable() : MorphTo
    {
        return $this->morphTo();
    }

    public function group() : BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function attachments() : HasMany {
        return $this->hasMany(PostAttachment::class);
    }

    public function likes() : HasMany {
        return $this->hasMany(PostLikes::class, 'post_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(PostComment::class, 'post_id')->latest()->whereNull('comment_id');
    }
}
