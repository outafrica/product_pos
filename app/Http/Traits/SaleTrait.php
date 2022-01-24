<?php

namespace App\Http\Traits;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;


/**
 * Caters for all functions for sales across all User Types
 */
trait SaleTrait
{
    // Displays all created sales
    public function list_sales(){

        if(Auth::user()->role_id == 1){

            $shop_id = Auth::user()->shop_id;

            return Sale::where('shop_id', $shop_id)->where('shop_id', '!=', 0)->orderBy('id', 'desc')->get();
        
        }else{

            return Sale::orderBy('id', 'desc')->get();

        }

    }
    
    // Adds sale to the DB
    public function add_sale($payload){

        $product_qauntity = Product::where('model_name', $payload['model_name'])->value('quantity');

        if($payload['quantity_sold'] > $product_qauntity){

            return response()->json('The quantity is higher the stock quantity', 430);

        }else{


            $buying_price = Product::where('model_name', $payload['model_name'])->value('buying_price');

            $wholesale_price = (1 + (Product::where('model_name', $payload['model_name'])->value('wholesale_ratio') / 100) ) * $buying_price;

            $distributor_price = (1 + (Product::where('model_name', $payload['model_name'])->value('distributor_ratio') / 100) ) * $buying_price;

            // var_dump($wholesale_price); die();

            if($payload['quantity_sold'] > 1){

                if($payload['selling_price'] > $distributor_price){

                    $new_quantity = $product_qauntity - $payload['quantity_sold'];
    
                    $total = $buying_price * $new_quantity;
            
                    $update = Product::where('model_name', $payload['model_name'])->update([
                        'quantity' => $new_quantity,
                        'total' => $total,
                    ]);
            
                    if($update){
            
                        return Sale::create($payload);
            
                    }

                }else{

                    $message = 'The allowed minimum selling price is Ksh.' . $distributor_price;
                    return response()->json( $message , 430);

                }

            }else{

                if($payload['selling_price'] > $wholesale_price){

                    $new_quantity = $product_qauntity - $payload['quantity_sold'];
            
                    $total = $buying_price * $new_quantity;
            
                    $update = Product::where('model_name', $payload['model_name'])->update([
                        'quantity' => $new_quantity,
                        'total' => $total,
                    ]);
            
                    if($update){
            
                        return Sale::create($payload);
            
                    }

                }else{

                    $message = 'The allowed minimum selling price is Ksh.' . $wholesale_price;
                    return response()->json( $message , 430);

                }

            }

        }

    }


    // Update a sale record
    public function update_sale($payload, $sale_id){

        $sale_quant = Sale::where('id', $sale_id)->value('quantity_sold');
        
        $sale_diff = $payload['quantity_sold'] - $sale_quant;

        $product_qauntity = Product::where('model_name', $payload['model_name'])->value('quantity');

        $buying_price = Product::where('model_name', $payload['model_name'])->value('buying_price');

        $new_quantity = $product_qauntity - $sale_diff;

        $total = $buying_price * $new_quantity;

        $update = Product::where('model_name', $payload['model_name'])->update([
            'quantity' => $new_quantity,
            'total' => $total,
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

