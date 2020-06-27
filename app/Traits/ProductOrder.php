<?php
namespace App\Traits;

use App\Traits\Responser;
use App\Models\Product;
use App\Models\ProductTransaction;
use App\Models\ProductTransactionDetail;
use Exception;
use Illuminate\Support\Str;

trait ProductOrder {
    use Responser;

    protected function productList()
    {
        return Product::select('slug', 'name', 'stock')->get();
    }

    protected function productsOfTransaction($products)
    {
        $new_products = [];
        foreach ($products as $key => $value) {
            $new_products[] = Product::whereSlug($value['slug'])->first();
        }

        return $new_products;
    }

    protected function productStockCheck($products, $products_queries)
    {
        $message = null;
        foreach ($products as $key => $value) {
            $product = $products_queries[$key];
            if ($product->stock < $value['quantity']) {
                $message = $product->name . ' are available for ' . $product->stock . ' item';
            }
        }
        
        return $message;
    }

    protected function decreaseStock($products, $products_queries)
    {
        $old_stock = [];
        $decrease_stock_status = true;
        $message = null;

        foreach ($products as $key => $value) {
            $product = $products_queries[$key];
            $old_stock[] = [
                'id'    => $product->id,
                'stock' => $product->stock
            ];

            try {
                $product->update([
                    'stock' => $product->stock - $value['quantity']
                ]);
            } catch (Exception $e) {
                $message = $product->name . ' not available for ' . $value['quantity'] . ' item';
                $decrease_stock_status = false;
            }
        }

        return compact('old_stock', 'decrease_stock_status', 'message');
    }

    protected function stockRecover($old_stock)
    {
        foreach ($old_stock as $key => $value) {
            Product::find($value['id'])->update([
                'stock' => $value['stock']
            ]);
        }
    }

    protected function createTransaction($request, $products)
    {
        $transaction = ProductTransaction::create([
            'name'  => $request->name,
            'code'  => Str::random(10)
        ]);

        foreach ($request->products as $key => $value) {
            $product = $products[$key];

            $transaction->details()->create([
                'product_id'    => $product->id,
                'quantity'      => $value['quantity']
            ]);
        }
    }

    protected function getAvailableProduct()
    {
        return Product::where('stock', '>', 0)->first();
    }
}