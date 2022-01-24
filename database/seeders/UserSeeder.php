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
            'username' => 'admin1',
            'role_id' => 2,
            'shop_id' => 0,
            'full_name' => 'Admin1',
            'email' => 'admin1'.'@admin.com',
            'password' => bcrypt('Products@2021'),
            'created_at'=> Date::now(),
            'updated_at'=> Date::now(),
        ]);

        DB::table('users')->insert([
            'username' => 'admin2',
            'role_id' => 2,
            'shop_id' => 0,
            'full_name' => 'Admin2',
            'email' => 'admin2'.'@admin.com',
            'password' => bcrypt('Admins@2021'),
            'created_at'=> Date::now(),
            'updated_at'=> Date::now(),
        ]);

        DB::table('users')->insert([
            'username' => 'agent1',
            'role_id' => 1,
            'shop_id' => 1,
            'full_name' => 'Agent',
            'email' => 'agent1'.'@agent.com',
            'password' => bcrypt('Agents@2021'),
            'created_at'=> Date::now(),
            'updated_at'=> Date::now(),
        ]);

        DB::table('users')->insert([
            'username' => 'agent2',
            'role_id' => 1,
            'shop_id' => 2,
            'full_name' => 'Super Agent',
            'email' => 'agent2'.'@agent.com',
            'password' => bcrypt('Agents@2021'),
            'created_at'=> Date::now(),
            'updated_at'=> Date::now(),
        ]);
    }
}
