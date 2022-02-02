<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'shop_id',
        'name',
        'model_name',
        'quantity_sold',
        'selling_price',
        'total',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

}
