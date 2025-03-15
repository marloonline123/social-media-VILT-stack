<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class BaseModel extends Model
{
    public static function generateRandomCharachters($prefix, $length = 14)
    {
        return $prefix . strtoupper(substr(bin2hex(random_bytes(8)), 0, $length));
    }
}
