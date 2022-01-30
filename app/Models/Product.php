<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'shop_id',
        'brand',
        'model_name',
        'image',
        'quantity',
        'buying_price',
        'distributor_price',
        'wholesale_price',
        'minimum_order_quantity',
        'total',
    ];

    /**
     * define user shop relationships.
     *
     * @var array
     */

    public function shop(){
        return $this->belongsTo(Shop::class);
     }

}
