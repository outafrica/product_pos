<?php

namespace App\Http\Controllers\Traits;

use App\Models\Product;
use App\Models\Sale;

/**
 * Caters for all functions for sales across all User Types
 */
trait SaleTrait
{
    // Displays all created sales
    public function list_sales(){

        return Sale::orderBy('id', 'desc')->get();

    }
    
    // Adds sale to the DB
    public function add_sale($payload){

        $product_qauntity = Product::where('model_name', $payload['model_name'])->value('quantity');

        $new_quantity = $product_qauntity - $payload['quantity_sold'];

        $update = Product::where('model_name', $payload['model_name'])->update([
            'quantity' => $new_quantity,
        ]);

        if($update){

            return Sale::create($payload);

        }

    }


    // Update a sale record
    public function update_sale($payload, $sale_id){

        $sale_quant = Sale::where('id', $sale_id)->value('quantity_sold');

        $sale_diff = $payload['quantity_sold'] - $sale_quant;

        $product_qauntity = Product::where('model_name', $payload['model_name'])->value('quantity');

        $new_quantity = $product_qauntity - $sale_diff;

        $update = Product::where('model_name', $payload['model_name'])->update([
            'quantity' => $new_quantity,
        ]);

        if($update){

            return Sale::where('id', $sale_id)
            ->update($payload);

        }

    }

    // Delete a sale record
    public function delete_sale($sale_id){

        return Sale::where('id', $sale_id)
        ->delete();

    }
    
    // List all products 
    public function list_allProducts(){

        return Product::orderBy('id', 'desc')->get();

    } 
    
}

