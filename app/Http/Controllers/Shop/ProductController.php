<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService) {
        $this->productService = $productService;
    }

    //show product
    public function show(Request $request, Product $product) {
        
        $product = $this->productService->getProduct($product->id);
        $this->productService->addProductToLastVisited($request->user(), $product);
        return inertia('Shop/Products/Show', [
            'product' => $product,
        ]);
    }

    //create product
    public function create() {
        $categories = $this->productService->listCategories();
        return inertia('Shop/Products/Create', [
            'categories' => $categories,
        ]);
    }

    //store product
    public function store(CreateProductRequest $request) {
        $product = $this->productService->createProduct($request->all());
        return redirect()->route('shop.product.show', $product->id)->with('message', 'Product created successfully');
    }

    //edit product
    public function edit($id) {
        $product = $this->productService->getProduct($id);
        $categories = $this->productService->listCategories();
        return inertia('Shop/Products/Edit', [
            'product' => $product,
            'categories' => $categories,
        ]);
    }

    //update product
    public function update(UpdateProductRequest $request, Product $product) {

        $product = $this->productService->updateProduct($request->all(), $product);
        return redirect()->route('shop.product.show', $product->id);
    }

    //delete product
    public function destroy(Product $product) {

        $this->productService->deleteProduct($product);
        return redirect()->route('shop.product.list')->with('message', 'Product deleted successfully');;
    }

    //set top product
    public function markAsTop(Product $product) {

        $this->productService->setTop($product);
        return redirect()->route('shop.product.show', $product->id)->with('message', 'Product marked as top');
    }

    //last visited products
    public function lastVisited(Request $request) {
        $user = $request->user();
        $products = $this->productService->getLastVisitedProducts($request->get('limit'), $user);
        return view('shop.products.last-visited', compact('products'));
    }
}
