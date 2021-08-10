<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Support\Str;
use App\Models\Product;

/**
 * Caters for all functions for products across all User Types
 */
trait ProductTrait
{
    // Displays all created products
    public function list_products(){

        return Product::orderBy('id', 'desc')->get();

    }
    
    // Adds products to the DB
    public function add_product($payload){

        return Product::create($payload);

    }


    // Update a product record
    public function update_product($payload, $product_id){

        return Product::where('id', $product_id)
            ->update($payload);

    }

    // Delete a product record
    public function delete_product($product_id, $path){

        if(file_exists($path)){

            @unlink($path);
        
        }else{

            return response()->json([
                'msg' => 'Unable to find image'
            ], 422);

        }

        return Product::where('id', $product_id)
            ->delete();

    }

    /**
    * 
    * Store a newly created resource in file storage.
    *
    **/
    public function upload_file($payload)
    {        
        $file = time() . '_' . $payload->getClientOriginalName();
        $payload->move(public_path('uploads'), $file);
        $path = '/uploads/' . $file;

        return $path;
    }

    /**
     * 
     * Delete created resource in file storage.
     *
    **/
    public function delete_file($payload)
    {

        $file = $payload;
        
        if(Str::contains($file, '/uploads/')){

            $path = public_path() . $file;

        }else{

            $path = public_path('uploads') . '/' . $file;


        }

        if(file_exists($path)){

            @unlink($path);
        
        }else{

            return response()->json([
                'msg' => 'Unable to find image'
            ], 422);

        }

        return "Success";

    }
    
}

