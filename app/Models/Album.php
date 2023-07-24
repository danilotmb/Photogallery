<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Album extends Model
{

    public function User()
{
    return $this->belongsTo(User::class);
}

    use HasFactory;
    use SoftDeletes; 
    // protected $fillable = ['album_name', 'description','user_id', 'album_thumb'];
    protected $guarded = ['id'];

    public function photo() 
    {

        return $this ->hasMany(Photo::class);  

    }

    public function getPathAttribute()
    {
        $url = $this->album_thumb;
        if(!str_starts_with($url, 'http'))
        {
            $url  = 'storage/'.$url;

        }
        return $url;
    }

    public function photos ()
    {
      
        return $this->hasMany(Photo::class, 'album_id', 'id');
    }

   // public function users ()
    //{
      //  return $this->belongsTo(User::class);
    //}
}
