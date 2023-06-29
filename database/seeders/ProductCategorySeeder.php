<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productsCount = 100;
        $categoriesCount = 20;

        $products = \App\Models\Product::factory($productsCount)->create();
        $categories = \App\Models\Category::factory($categoriesCount)->create();

        $products->each(function ($product) use ($categories) {
            $product->categories()->attach(
                $categories->random(rand(1, 5))->pluck('id')->toArray()
            );
        });
    }
}
