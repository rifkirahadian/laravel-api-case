<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTransaction extends Model
{
    protected $fillable = [
        'name',
        'code'
    ];

    public function details()
    {
        return $this->hasMany(ProductTransactionDetail::class, 'product_transaction_id');
    }
}
