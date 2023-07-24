<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Album>
 */
class AlbumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cats = [
            'abstract',
            'animals',
            'business',
            'cats',
            'city',
            'food',
            'nightlife',
            'fashion',
            'people',
            'nature',
            'sports',
            'technics',
            'transport'
        ];


        //$user = User::inRandomOrder()->first();
        return [
            'album_name' => $this -> faker -> text(60),
            'album_thumb' => $this -> faker -> imageUrl(),
            'description' => $this -> faker -> text(120),
            'created_at' => $this -> faker -> dateTime(),
            'user_id' => User::factory()
        ];
    }
}
