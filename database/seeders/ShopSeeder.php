<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('shops')->insert([
            'name' => 'Company Name',
            'Location' => 'Moi Avenue',
            'created_at'=> Date::now(),
            'updated_at'=> Date::now(),
        ]);

        DB::table('shops')->insert([
            'name' => 'Company Name',
            'Location' => 'FireStation',
            'created_at'=> Date::now(),
            'updated_at'=> Date::now(),
        ]);
    }
}
