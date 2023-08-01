<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Album extends Model
{
    use HasFactory;
    use SoftDeletes; 


    protected $fillable = ['album_name', 'description','user_id', 'album_thumb'];
    protected $guarded = ['id'];


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

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        // album_category , album_id, category_id
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    
    
   

    public function photo() 
    {

        return $this ->hasMany(Photo::class);  

    }

    

   

   // public function users ()
    //{
      //  return $this->belongsTo(User::class);
    //}
}
