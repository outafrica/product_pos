<?php

namespace App\Http\Controllers\Traits;

use App\Models\Expense;
use App\Models\ExpenseSubType;
use App\Models\ExpenseType;
use Illuminate\Support\Facades\Auth;

/**
 * Caters for all functions for expenses across all User Types
 */
trait ExpenseTrait
{
    // Displays all created expenses
    public function list_expenses(){

        if(Auth::user()->role_id == 1){

            return Expense::where('type', 'Other')->orderBy('id', 'desc')->get();
        
        }else{

            return Expense::orderBy('id', 'desc')->get();

        }

    }

    //List all expense type
    public function list_expense_types(){

        if(Auth::user()->role_id == 1){

            return ExpenseType::where('name', 'Other')->orderBy('id', 'asc')->get();

        }else{

            return ExpenseType::orderBy('id', 'asc')->get();

        }

    }
 
    //List all expense type
    public function list_expense_sub_types(){

        if(Auth::user()->role_id == 1){
            
            return ExpenseSubType::where('expense_type_id', 5)->orderBy('id', 'asc')->get();

        }else{

            return ExpenseSubType::orderBy('id', 'asc')->get();

        }

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

