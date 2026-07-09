<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use App\Models\Category;
use App\Http\Requests\UpdateCategoryRequest;


class CategoryController extends Controller
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        $categories = $this->categoryService->getAll(
            $request->search,
            $request->integer('per_page', 10)
        );

        return response()->json([
            'success' => true,
            'data' => CategoryResource::collection($categories),
        ]);
    }

    
    public function store(StoreCategoryRequest $request)
    {
        $category = $this->categoryService->create($request->validated());
        
        return response()->json([
            'success' => true,
            'message' => 'Category created successfully.',
            'data' => new CategoryResource($category),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return response()->json([
            'success' => true,
            'data' => new CategoryResource($category),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category = $this->categoryService->updateCategory($category, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully.',
            'data' => new CategoryResource($category),
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $this->categoryService->deleteCategory($category);
    }
}
