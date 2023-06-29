<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function create() {
        return inertia('Shop/Categories/Create');
    }

    public function store(CreateCategoryRequest $request) {
        $category = $this->categoryService->createCategory($request->all());
        return redirect()->route('shop.category.show', $category->id)->with('message', 'Category created successfully');
    }
}
