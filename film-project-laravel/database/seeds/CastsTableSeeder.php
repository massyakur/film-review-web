<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CastsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for($i=1;$i<=50;$i++){
            DB::table('casts')->insert([
            'id' => $i,
            'name' => $faker->name(),
            'age' => random_int(5, 70),
            'bio' => $faker->text(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        }
        
        
    }
}
