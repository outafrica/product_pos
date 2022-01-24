<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class ExpenseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('expense_types')->insert([
            'name' => 'Bills',
            'created_at'=> Date::now(),
            'updated_at'=> Date::now(),
        ]);
        DB::table('expense_types')->insert([
            'name' => 'Shop',
            'created_at'=> Date::now(),
            'updated_at'=> Date::now(),
        ]);
        DB::table('expense_types')->insert([
            'name' => 'Cargo',
            'created_at'=> Date::now(),
            'updated_at'=> Date::now(),
        ]);
        DB::table('expense_types')->insert([
            'name' => 'Salary',
            'created_at'=> Date::now(),
            'updated_at'=> Date::now(),
        ]);
        DB::table('expense_types')->insert([
            'name' => 'Other',
            'created_at'=> Date::now(),
            'updated_at'=> Date::now(),
        ]);

    }
}
