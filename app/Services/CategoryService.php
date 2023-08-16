<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryService
{

    public function listCategories($limit = null) {
        return Category::orderBy('name', 'asc')
                ->simplePaginate($limit);
    }

    public function getCategory($id) : Category {
        return Category::findOrFail($id);
    }

    public function createCategory($data) : Category {
        $category = new Category();
        $category->name = $data['name'];
        $category->save();

        return $category;
    }

    public function searchCategories($search, $limit = 20) {
        return DB::table('categories')->where('name', 'like', "$search%")
                ->orderBy('name', 'asc')
                ->limit($limit)
                ->select('id AS value', 'name AS label')
                ->get();
    }

}