<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ProductTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{

    use ProductTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return $this->list_products();
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
            'brand' => 'required',
            'model_name' => 'required',
            'quantity' => 'required',
            'buying_price' => 'required',
            'shop_id' => 'required',
            'minimum_order_quantity' => 'required',
            'distributor_price' => 'required',
            'wholesale_price' => 'required',

        ]);

        $payload = array(
            'name' => $request->name,
            'brand' => $request->brand,
            'model_name' => $request->model_name . ' (' . $request->shop_id . ')',
            'quantity' => $request->quantity,
            'image'=> $request->image,
            'shop_id' => $request->shop_id,
            'distributor_price' => $request->distributor_price,
            'wholesale_price' => $request->wholesale_price,
            'buying_price' => $request->buying_price,
            'minimum_order_quantity' => $request->minimum_order_quantity,
            'total' => $request->buying_price * $request->quantity,
        );
        
        return $this->add_product($payload);
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
        $this->validate($request, [

            'name' => 'required',
            'brand' => 'required',
            'model_name' => 'required',
            'quantity' => 'required',
            'buying_price' => 'required',
            'minimum_order_quantity' => 'required',
            'distributor_price' => 'required',
            'wholesale_price' => 'required',

        ]);

        $product_id = $request->id;

        $payload = array(
            'name' => $request->name,
            'brand' => $request->brand,
            'model_name' => $request->model_name . ' (' . $request->shop_id . ')',
            'quantity' => $request->quantity,
            'image'=> $request->image,
            'distributor_price' => $request->distributor_price,
            'wholesale_price' => $request->wholesale_price,
            'buying_price' => $request->buying_price,
            'minimum_order_quantity' => $request->minimum_order_quantity,
            'total' => $request->buying_price * $request->quantity,
        );

        return $this->update_product($payload, $product_id);

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

        $path =  public_path() . $request->image;
        $product_id = $request->id;

        return $this->delete_product($product_id, $path);
    }

    /**
     * Store a newly created resource in file storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:jpeg,jpg,png|',
        ]);
        
        $payload = $request->file;

        return $this->upload_file($payload);
    }

     /**
     * Store a newly created resource in file storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete_upload(Request $request)
    {
        $this->validate($request, [
            'image' => 'required',
        ]);

        $payload = $request->image;

        return $this->delete_file($payload);

    }
}
