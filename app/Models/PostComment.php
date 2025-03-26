<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PostComment extends Model
{
    protected $fillable = [
        'body',
        'user_id',
        'post_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function parentComment(): BelongsTo
    {
        return $this->belongsTo(PostComment::class, 'comment_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(PostComment::class, 'comment_id')->latest()->with('replies');
    }

    public function likes(): HasMany
    {
        return $this->hasMany(CommentLikes::class, 'comment_id');
    }
}
