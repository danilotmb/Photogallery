<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Photo extends Model
{
    use HasFactory;
    use SoftDeletes;


    public function album()
    {
        return $this->belongsTo(Album::class);
    }


    public function getPathAttribute()
    {
        $url = $this->img_path;
        if(!str_starts_with($url, 'http'))
        {
            $url  = 'storage/'.$url;

        }
        return $url;
    }
}
