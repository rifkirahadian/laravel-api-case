<?php
namespace App\Traits;

use App\Traits\Responser;
use App\Models\Product;
use Exception;

trait ProductOrder {
    use Responser;

    protected function productList()
    {
        return Product::select('slug', 'name', 'stock')->get();
    }
}