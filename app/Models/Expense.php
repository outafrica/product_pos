<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'shop_id',
        'type',
        'sub_type',
        'beneficiary_name',
        'receipt_number',
        'amount',
        'month_paid',
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
