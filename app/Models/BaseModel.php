<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class BaseModel extends Model
{
    public static function uploadFile($file, $path, $disk = 'public')
    {
        return Storage::disk($disk)->putFile($path, $file);
    }
}
