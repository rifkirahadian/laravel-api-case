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

    public function productTransaction(Request $request)
    {
        $this->formValidation($request->all(), [
            'name'                  => 'required',
            'products'              => 'required|array',
            'products.*.slug'       => 'required|exists:products,slug',
            'products.*.quantity'   => 'required|integer',
        ]);
        
        $products = $this->productsOfTransaction($request->products);

        $product_stock_check = $this->productStockCheck($request->products, $products);
        if ($product_stock_check) {
            return $this->badRequest($product_stock_check);
        }

        $decrease_stock = $this->decreaseStock($request->products, $products);
        if (!$decrease_stock['decrease_stock_status']) {
            $this->stockRecover($decrease_stock['old_stock']);
            return $this->badRequest($decrease_stock['message']);
        }

        $this->createTransaction($request, $products);

        $this->successResponse(null, 'Transaction Success');
    }
}
