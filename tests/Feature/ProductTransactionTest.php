<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Traits\ProductOrder;

class ProductTransactionTest extends TestCase
{
    use ProductOrder;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testSuccessTransaction()
    {
        $product = $this->getAvailableProduct();
        $response = $this->post('/api/product/transaction',[
            'name'      => 'Rifki',
            'products'  => [
                [
                    'slug'      => $product->slug,
                    'quantity'  => 1
                ]
            ]
        ]);

        $response->assertStatus(200);

        $this->stockRecover([
            ['id' => $product->id, 'stock' => 1]
        ]);
    }

    public function testOutOfStock()
    {
        $product = $this->getAvailableProduct();
        $response = $this->post('/api/product/transaction',[
            'name'      => 'Rifki',
            'products'  => [
                [
                    'slug'      => $product->slug,
                    'quantity'  => $product->stock+1
                ]
            ]
        ]);

        $response->assertStatus(400);
    }
}
