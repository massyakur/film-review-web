<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GenresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('genres')->insert([
            'id' => 1,
            'name' => "Horror",//Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('genres')->insert([
            'id' => 2,
            'name' => "Action",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('genres')->insert([
            'id' => 3,
            'name' => "Science Fiction",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('genres')->insert([
            'id' => 4,
            'name' => "Romance",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('genres')->insert([
            'id' => 5,
            'name' => "Ficton",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('genres')->insert([
            'id' => 6,
            'name' => "Thriller",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('genres')->insert([
            'id' => 7,
            'name' => "Drama",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('genres')->insert([
            'id' => 8,
            'name' => "Comedy",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('genres')->insert([
            'id' => 9,
            'name' => "Musical",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('genres')->insert([
            'id' => 10,
            'name' => "Documentary",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('genres')->insert([
            'id' => 11,
            'name' => "Animation",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('genres')->insert([
            'id' => 12,
            'name' => "Indie Film",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
