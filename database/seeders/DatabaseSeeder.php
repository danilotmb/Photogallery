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

        $this->call(CategorySeeder::class);

        User::factory(100) -> has(
            Album::factory(200) -> has(
                Photo::factory(200)
            )
        )->create();

        $this->call(AlbumCategory::class);


        

        // \App\Models\User::factory(10)->create();
        /*
        $this->call(UserSeeder::class);
        $this->call(AlbumSeeder::class);
        $this->call(PhotoSeeder::class);
        */

    }
}
