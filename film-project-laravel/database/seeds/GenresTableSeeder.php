<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Str;

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
            'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
            'name' => "Horror",//Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('genres')->insert([
            'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
            'name' => "Action",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('genres')->insert([
            'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
            'name' => "Science Fiction",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('genres')->insert([
            'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
            'name' => "Romance",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('genres')->insert([
            'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
            'name' => "Ficton",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('genres')->insert([
            'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
            'name' => "Thriller",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('genres')->insert([
            'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
            'name' => "Drama",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('genres')->insert([
            'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
            'name' => "Comedy",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('genres')->insert([
            'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
            'name' => "Musical",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('genres')->insert([
            'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
            'name' => "Documentary",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('genres')->insert([
            'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
            'name' => "Animation",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('genres')->insert([
            'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
            'name' => "Indie Film",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
