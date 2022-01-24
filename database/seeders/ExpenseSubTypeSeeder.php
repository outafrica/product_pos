<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class ExpenseSubTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('expense_sub_types')->insert([
            'expense_type_id' => 1,
            'name' => 'Kanjo',
            'created_at'=> Date::now(),
            'updated_at'=> Date::now(),
        ]);

        DB::table('expense_sub_types')->insert([
            'expense_type_id' => 1,
            'name' => 'Electricity',
            'created_at'=> Date::now(),
            'updated_at'=> Date::now(),
        ]);

        DB::table('expense_sub_types')->insert([
            'expense_type_id' => 1,
            'name' => 'Water',
            'created_at'=> Date::now(),
            'updated_at'=> Date::now(),
        ]);

        DB::table('expense_sub_types')->insert([
            'expense_type_id' => 1,
            'name' => 'Rent',
            'created_at'=> Date::now(),
            'updated_at'=> Date::now(),
        ]);

        DB::table('expense_sub_types')->insert([
            'expense_type_id' => 2,
            'name' => 'Chinam Nairobi',
            'created_at'=> Date::now(),
            'updated_at'=> Date::now(),
        ]);

        DB::table('expense_sub_types')->insert([
            'expense_type_id' => 2,
            'name' => 'Dubai',
            'created_at'=> Date::now(),
            'updated_at'=> Date::now(),
        ]);

        DB::table('expense_sub_types')->insert([
            'expense_type_id' => 5,
            'name' => 'Daily Expense',
            'created_at'=> Date::now(),
            'updated_at'=> Date::now(),
        ]);
    }
}
