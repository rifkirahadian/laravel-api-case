<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTransactionDetail extends Model
{
    protected $fillable = [
        'product_transaction_id',
        'product_id',
        'quantity'
    ];
}
