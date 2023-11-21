<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $cacheKey = 'products-index';

        $page = $request->input('page', 5);
        $perPage = $request->input('per_page', 10);

        // $data = Cache::remember($cacheKey, now()->addHour(), function () use ($perPage, $page) {
        //     // Use the paginate method to retrieve products with pagination
        //     return Product::paginate($perPage, ['*'], 'page', $page);
        // });

        $categories = $request->input('categories', []);

        if (count($categories) > 0) {
            $data = Product::search($request->input('search', ''))
            ->whereIn('category_id', $request->input('categories', []))
            ->paginate($perPage, '', intval($page));
        } else {
            $data = Product::search($request->input('search', ''))
            ->paginate($perPage, '', intval($page));
        }

        $data->load('category');

        return response()->json([
            'data' => $data->items(),
            'count' => $data->total(),
            'per_page' => $data->perPage(),
            'current_page' => $data->currentPage(),
            'message' => 'Success',
            'status' => 200,
        ]);
    }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function show(Product $product): JsonResponse
    {
        $product = $product->load('category');
        return response()->json([
            'data' => $product,
            'status' => 200,
        ]);
    }
}
