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

        $data = Product::search($request->input('search', ''))
        ->whereIn('category_id', $request->input('categories', []))->paginate($perPage, '', intval($page));
        $data->load('category');

        return response()->json([
            'data' => $data->items(), // Get the items for the current page
            'count' => $data->total(), // Total count of products
            'per_page' => $data->perPage(), // Number of items per page
            'current_page' => $data->currentPage(), // Current page number
            'message' => 'Success',
            'status' => 200,
        ]);
    }

    public function show(Product $product)
    {
        $product = $product->load('category');
        return response()->json([
            'data' => $product,
            'status' => 200,
        ]);
    }
}
