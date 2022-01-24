<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ExpenseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    use ExpenseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return $this->list_expenses();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = array();

        if(Auth::user()->role_id == 2){

            $this->validate($request, [
                'type' => 'required',
                'sub_type' => 'required',
                'beneficiary_name' => 'required',
                'amount' => 'required',
                'shop_id' => 'required',
                'month_paid' => 'required',
            ]);
    
            $payload = array(
                'type' => $request->type,
                'sub_type' => $request->sub_type,
                'beneficiary_name' => $request->beneficiary_name,
                'receipt_number'=> $request->receipt_number,
                'amount' => $request->amount,
                'shop_id' => $request->shop_id,
                'month_paid' => $request->month_paid,
            );

            $data = $payload;

        }else{

            $this->validate($request, [
                'type' => 'required',
                'sub_type' => 'required',
                'beneficiary_name' => 'required',
                'amount' => 'required',
                'month_paid' => 'required',
            ]);
    
            $payload = array(
                'type' => $request->type,
                'sub_type' => $request->sub_type,
                'beneficiary_name' => $request->beneficiary_name,
                'receipt_number'=> $request->receipt_number,
                'amount' => $request->amount,
                'shop_id' => Auth::user()->shop_id,
                'month_paid' => $request->month_paid,
            );

            $data = $payload;

        }


        return $this->add_expense($data);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $this->validate($request, [
            'type' => 'required',
            'sub_type' => 'required',
            'beneficiary_name' => 'required',
            'amount' => 'required',
            'month_paid' => 'required',
        ]);

        $expense_id = $request->id;

        $payload = array(
            'type' => $request->type,
            'sub_type' => $request->sub_type,
            'beneficiary_name' => $request->beneficiary_name,
            'receipt_number'=> $request->receipt_number,
            'amount' => $request->amount,
            'month_paid' => $request->month_paid,
        );

        return $this->update_expense($payload, $expense_id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $this->validate($request, [
            'id' => 'required',
        ]);

        return $this->delete_expense($request->id);
    }

    /**
     * Lists all expense types.
     */
    public function list_expenseTypes()
    {
        return $this->list_expense_types();
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function list_expense_subTypes()
    {

        return $this->list_expense_sub_types();

        
    }


}
