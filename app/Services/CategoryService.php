<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function create(array $data): Category
    {
        return Category::create($data);
    }

    public function getAll(?string $search = null, int $perPage = 10)
    {
        return Category::query() 
            ->withCount('products')
            ->when($search, function ($query) use ($search)
            {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
            })->paginate($perPage);
    }
   
    public function updateCategory(Category $category, array $data): Category
    {
        $category->update($data);

        return $category->fresh();
    }

    public function deleteCategory(Category $category): void
    {
        $category->delete();
    }
}