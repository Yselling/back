<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $cacheKey = 'products-index';

        $page = $request->input('page', 5);
        $perPage = $request->input('per_page', 10);

        // $data = Cache::remember($cacheKey, now()->addHour(), function () use ($perPage, $page) {
        //     // Use the paginate method to retrieve products with pagination
        //     return Product::paginate($perPage, ['*'], 'page', $page);
        // });

        $data = Product::with('category')->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'data' => $data->items(), // Get the items for the current page
            'count' => $data->total(), // Total count of products
            'per_page' => $data->perPage(), // Number of items per page
            'current_page' => $data->currentPage(), // Current page number
            'message' => 'Success',
            'status' => 200,
        ]);
    }

    public function store(ProductRequest $request)
    {
        $this->authorize('create', Product::class);

        return new ProductResource(Product::create($request->validated()));
    }

    public function show(Product $product)
    {
        $product = $product->load('category');
        return response()->json([
            'data' => $product,
            'status' => 200,
        ]);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $this->authorize('update', $product);

        $product->update($request->validated());

        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        $product->delete();

        return response()->json();
    }
}
