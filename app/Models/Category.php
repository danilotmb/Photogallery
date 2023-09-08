<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Album;
use Illuminate\Database\Eloquent\Builder as Builder;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['category_name', 'user_id'];

    public function albums()
    {
        return $this->belongsToMany(Album::class)->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeGetCategoriesByUserId(Builder $builder, User $user)
{
    return $builder->where('user_id', $user->id)->withCount('albums')->orderBy('category_name');
}

}