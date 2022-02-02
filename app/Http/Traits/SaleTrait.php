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

            $sale = Sale::where('shop_id', $shop_id)->where('shop_id', '!=', 0)->orderBy('id', 'desc')->get();
            
            return $sale;
        
        }else{

            $sale = Sale::orderBy('id', 'desc')->get();

            return $sale;

        }

    }
    
    // Adds sale to the DB
    public function add_sale($payload){

        $product_qauntity = Product::where('id', $payload['product_id'])->value('quantity');

        if($payload['quantity_sold'] > $product_qauntity){

            return response()->json('The quantity is higher than stock available', 430);

        }else{


            $buying_price = Product::where('id', $payload['product_id'])->value('buying_price');
            
            $wholesale_price = Product::where('id', $payload['product_id'])->value('wholesale_price');

            $distributor_price = Product::where('id', $payload['product_id'])->value('distributor_price');

            $moq = Product::where('id', $payload['product_id'])->value('minimum_order_quantity');

            // var_dump($wholesale_price); die();

            if($payload['quantity_sold'] >= $moq){

                if($payload['selling_price'] > $distributor_price){

                    $new_quantity = $product_qauntity - $payload['quantity_sold'];
    
                    $total = $buying_price * $new_quantity;
            
                    $update = Product::where('id', $payload['product_id'])->update([
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
            
                    $update = Product::where('id', $payload['product_id'])->update([
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

        // get original quantity sold before edit
        $sale_quant = Sale::where('id', $sale_id)->value('quantity_sold');
        
        // check whether quantity sold exceeds the original sale
        $sale_diff = $payload['quantity_sold'] - $sale_quant;

        // get product quantity thats remaining
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

        if(Auth::user()->role_id == 1){

            $shop_id = Auth::user()->shop_id;

            return Product::where('shop_id', $shop_id)->where('shop_id', '!=', 0)->orderBy('id', 'desc')->get();
        
        }else{

            return Product::orderBy('id', 'desc')->get();

        }

    } 
    
}

