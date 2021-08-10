<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'role_id' => 2,
            'full_name' => 'Super Admin',
            'email' => 'admin'.'@admin.com',
            'password' => bcrypt('Products@2021'),
            'created_at'=> Date::now(),
            'updated_at'=> Date::now(),
        ]);

        DB::table('users')->insert([
            'role_id' => 2,
            'full_name' => 'Admin',
            'email' => 'admin'.'@admin.com',
            'password' => bcrypt('Admins@2021'),
            'created_at'=> Date::now(),
            'updated_at'=> Date::now(),
        ]);

        DB::table('users')->insert([
            'role_id' => 1,
            'full_name' => 'Super Agent',
            'email' => 'agent'.'@agent.com',
            'password' => bcrypt('Agents@2021'),
            'created_at'=> Date::now(),
            'updated_at'=> Date::now(),
        ]);
    }
}
