<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Album;
use App\Models\AlbumCategory;
use App\Models\Category;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

       User::truncate();
       AlbumCategory::truncate();
       Category::truncate();
       Album::truncate();
       Photo::truncate();

       User::factory(50)->has(
        Album::factory(20)->has(
            Photo::factory(20)
        )
    )->create();
    $this->call(CategorySeeder::class);
    $this->call(AlbumCategorySeeder::class);

        // \App\Models\User::factory(10)->create();
        /*
        $this->call(UserSeeder::class);
        $this->call(AlbumSeeder::class);
        $this->call(PhotoSeeder::class);
        */

    }
}
