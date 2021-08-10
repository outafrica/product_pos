<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'User',
            'created_at'=> Date::now(),
            'updated_at'=> Date::now(),
        ]);
        DB::table('roles')->insert([
            'name' => 'Admin',
            'created_at'=> Date::now(),
            'updated_at'=> Date::now(),
        ]);
    }
}
