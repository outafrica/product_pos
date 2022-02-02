<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\SaleTrait;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $shop_id = Auth::user()->shop_id;

        $this->validate($request, [
            'product_id' => 'required',
            'quantity_sold' => 'required',
            'selling_price' => 'required',
        ]);

        $product_brand = Product::where('id', $request->product_id)->value('brand');
        $model_name = Product::where('id', $request->product_id)->value('model_name');
        $name = Product::where('id', $request->product_id)->value('name');

        $payload = array(
            'shop_id' => $shop_id,
            'product_id' => $request->product_id,
            'name' => $name,
            'model_name' => $product_brand . ' ' . $model_name,
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
            'quantity_sold' => 'required',
        ]);

        $sale_id = $request->id;

        $selling_price = Sale::where('id', $sale_id)->value('selling_price');
        $model_name = Sale::where('id', $sale_id)->value('model_name');

        $payload = array(
            'model_name' => $model_name,
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
