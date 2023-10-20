<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        $cacheKey = 'products-index';

        $data = Cache::remember($cacheKey, now()->addHour(), function () {
            return ProductResource::collection(Product::all());
        });

        return response()->json([
            'data' => $data,
            'count' => count($data),
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
        $this->authorize('view', $product);

        return new ProductResource($product);
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
