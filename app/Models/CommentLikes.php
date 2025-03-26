<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommentLikes extends Model
{
    protected $fillable = [
        'user_id',
        'comment_id',
    ];

    public function comment() :BelongsTo {
        return $this->belongsTo(CommentPost::class);
    }
}
