<?php

namespace App\Http\Controllers\Traits;

use App\Models\Expense;
use App\Models\ExpenseSubType;
use App\Models\ExpenseType;

/**
 * Caters for all functions for expenses acrooss all User Types
 */
trait ExpenseTrait
{
    // Displays all created expenses
    public function list_expenses(){

        return Expense::orderBy('id', 'desc')->get();

    }

    //List all expense type
    public function list_expense_types(){

        return ExpenseType::orderBy('id', 'asc')->get();

    }
 
    //List all expense type
    public function list_expense_sub_types(){

        return ExpenseSubType::orderBy('id', 'asc')->get();

    }
    
    // Adds expenses to the DB
    public function add_expense($payload){

        return Expense::create($payload);

    }


    // Update a expense record
    public function update_expense($payload, $expense_id){

        return Expense::where('id', $expense_id)
        ->update($payload);

    }

    // Delete a expense record
    public function delete_expense($expense_id){

        return Expense::where('id', $expense_id)
        ->delete();

    }
    
}

