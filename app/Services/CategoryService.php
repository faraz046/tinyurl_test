<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{

    public function listCategories($limit = null) {
        return Category::
                when($limit, function($query, $limit) {
                    return $query->limit($limit);
                })
                ->orderBy('name', 'asc')
                ->get();
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

}