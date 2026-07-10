<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Services\ProductService;
use App\Http\Resources\ProductResource;


class ProductController extends Controller
{
    public function __construct(
        private readonly ProductService $productService
    ){

    }

    public function store(StoreProductRequest $request)
    {
        $product = $this->productService->create(
            $request->validated()
        );

        return $this->successResponse(
            new ProductResource($product),
            'Product created Successfully',
            201
        );

    }

    public function index(Request $request)
    {

        $products = $this->productService->paginate(

            $request->search,

            $request->integer('category_id'),

            $request->integer('per_page',10)

        );


        return $this->successResponse(
            ProductResource::collection($products),
            'Products retrieved successfully.'
        );

    }

    
    public function show(Product $product)
    {
        $product -> load([
            'category',
            'stock'
        ]);

        return $this->successResponse(
            new ProductResource($product),
            'Product retrieved successfully.'
        );
    }

   
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product = $this->productService->update(
            $product, 
            $request->validated()
        );

        return $this->successResponse(
            new ProductResource($product),
            'Product updated successfully.'
        );
    }

    
    public function destroy(Product $product)
    {
        $this->productService->delete($product);

        return $this->successResponse(
            null,
            'product deleted successfully.'
        );
    }
   
}
