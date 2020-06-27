<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ProductOrder;

class ProductController extends Controller
{
    use ProductOrder;

    public function index()
    {
        $products = $this->productList();

        $this->successResponse($products, null);
    }
}
