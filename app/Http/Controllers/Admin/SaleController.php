<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\SaleTrait;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{

    use SaleTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return $this->list_sales();
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
        $this->validate($request, [
            'name' => 'required',
            'model_name' => 'required',
            'quantity_sold' => 'required',
            'selling_price' => 'required',
        ]);

        $payload = array(
            'name' => $request->name,
            'model_name' => $request->model_name,
            'quantity_sold' => $request->quantity_sold,
            'selling_price' => $request->selling_price,
            'total' => $request->selling_price * $request->quantity_sold,
        );

        return $this->add_sale($payload);

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
            'name' => 'required',
            'model_name' => 'required',
            'quantity_sold' => 'required',
        ]);

        $sale_id = $request->id;

        $selling_price = Sale::where('id', $sale_id)->value('selling_price');

        $payload = array(
            'name' => $request->name,
            'model_name' => $request->model_name,
            'quantity_sold' => $request->quantity_sold,
            'total' => $selling_price * $request->quantity_sold,
        );

        return $this->update_sale($payload, $sale_id);
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
            'id' => 'required'
        ]);

        $sale_id = $request->id;

        return $this->delete_sale($sale_id);

    }

    /**
     * Get List of products for sales addition
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getProductsList()
    {
        //
        return $this->list_allProducts();

    }
}
