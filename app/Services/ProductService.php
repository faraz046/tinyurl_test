<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ProductService
{

    public function listProducts($limit = 10, $category = null, $sort = null) {

        if(strpos($sort, 'category') !== false || $category) {
            //if sorting by category or filtering by category, use the materialized view table
            $data = DB::table('mv_products_by_category')
                    ->distinct('id')
                    ->select('id')
                    ->when($category, function($query, $category) {
                        return $query->where('category_id', $category);
                    })
                    ->when($sort, function($query, $sort) {
                        if($sort == 'category_desc') {
                            return $query->orderBy('category_name', 'desc');
                        } else if ($sort == 'category_asc') {
                            return $query->orderBy('category_name', 'asc');
                        } else if ($sort == 'price_asc') {
                            return $query->orderBy('price', 'asc');
                        } else if($sort == 'price_desc') {
                            return $query->orderBy('price', 'desc');
                        } else if($sort == 'name_asc') {
                            return $query->orderBy('product_name', 'asc');
                        } else if($sort == 'name_desc') {
                            return $query->orderBy('product_name', 'desc');
                        } else if($sort == 'latest') {
                            return $query->orderBy('created_at', 'desc');
                        }
                    })
                    ->simplePaginate($limit);

                $data->setCollection(
                    Product::whereIn('id', $data->pluck('id'))->get()
                );
        }
        else
        {
            $data = Product::when($sort, function($query, $sort) {
                        if($sort == 'price_asc') {
                            return $query->orderBy('price', 'asc');
                        } else if($sort == 'price_desc') {
                            return $query->orderBy('price', 'desc');
                        } else if($sort == 'name_asc') {
                            return $query->orderBy('products.name', 'asc');
                        } else if($sort == 'name_desc') {
                            return $query->orderBy('products.name', 'desc');
                        } else if($sort == 'latest') {
                            return $query->orderBy('created_at', 'desc');
                        }
                    })
                    ->simplePaginate($limit);   
        }
        return $data;

    }

    public function getProduct($id) : Product {
        return Product::with(['categories' => function($query) {
            $query->orderBy('categories.name', 'asc');
        }])->findOrFail($id);
    }

    public function createProduct($data) : Product {
        $product = new Product();
        $product->name = $data['name'];
        $product->description = $data['description'];
        $product->price = $data['price'];
        $product->save();

        //attach categories
        $product->categories()->attach($data['categories']);

        return $product;
    }

    public function updateProduct($data, $product) : Product {
        $product->name = $data['name'];
        $product->description = $data['description'];
        $product->price = $data['price'];
        $product->save();

        //attach categories
        $product->categories()->sync($data['categories']);

        return $product;
    }

    public function deleteProduct($product) {
        $product->categories()->detach();
        $product->delete();
    }

    //mark product as top
    public function setTop($product) {
        $product->top = true;
        $product->save();
    }

    //remove top mark from product
    public function removeTop($product) {
        $product->top = false;
        $product->save();
    }

    //get top products
    public function getTopProducts() {
        //cache top products for 1 day
        return Cache::remember('top_products', 1440, function () {
            return Product::where('top', true)
                ->select('id', 'name', 'price', 'description')
                ->limit(20)
                ->orderBy('created_at', 'desc')
                ->get();
        });
    }

    //get last visited products
    public function getLastVisitedProducts(User $user) {
        return $user->viewedProducts()
                ->orderBy('pivot_updated_at', 'desc')
                ->limit(10)
                ->get();
    }

    public function listCategories() : Collection {
        return Category::OrderBy('name','asc')->get();
    }

    public function addProductToLastVisited(User $user, Product $product) {
        $user->viewedProducts()->syncWithoutDetaching([$product->id => ['updated_at' => now()]]);
    }

    
}