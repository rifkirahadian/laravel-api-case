<?php

use Illuminate\Database\Seeder;
use App\Models\Product;
use Faker\Factory;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $bulk = [];
        foreach (range(1,5) as $key => $value) {
            $product_name = $faker->company;
            $bulk[] = [
                'name'  => $product_name,
                'slug'  => Str::slug($product_name, '-'),
                'stock' => rand(1,7)
            ];
        }
        Product::insert($bulk);
    }
}
