<?php
namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ShopController extends Controller
{

    protected $productService;
    protected $categoryService;

    public function __construct(ProductService $productService, CategoryService $categoryService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
    }

    public function listProducts(Request $request)
    {
        $products = $this->productService->listProducts(20, $request->get('category'), $request->get('sort', 'latest'));
        $topProducts = $this->productService->getTopProducts();
        $lastViewedProducts = $this->productService->getLastVisitedProducts($request->user());
        return inertia('Shop/Products/List', [
            'products' => $products,
            'topProducts' => $topProducts,
            'lastViewedProducts' => $lastViewedProducts,
            'sort' => $request->get('sort', 'latest'),
        ]);
    }

    public function listCategories()
    {
        $categories = $this->categoryService->listCategories();
        return inertia('Shop/Categories/List', [
            'categories' => $categories,
        ]);
    }

    public function listCategoryProducts(Request $request, Category $category)
    {
        $products = $this->productService->listProducts(20, $category->id, $request->get('sort', 'latest'));
        return inertia('Shop/Categories/Show', [
            'products' => $products,
            'category' => $category,
            'sort' => $request->get('sort', 'latest'),
        ]);
    }
}
