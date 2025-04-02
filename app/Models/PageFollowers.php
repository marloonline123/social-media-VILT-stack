<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageFollowers extends Model
{
    protected $fillable = [
        'page_id',
        'follower_id',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id');
    }
}
