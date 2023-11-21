<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GenderResource;
use App\Models\Gender;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GenderController extends Controller
{

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $cacheKey = 'genders-index';

        $data = Cache::remember($cacheKey, now()->addHour(), function () {
            return Gender::all();
        });

        return response()->json([
            'data' => $data,
            'count' => count($data),
            'message' => 'Success',
            'status' => 200,
        ]);
    }
}
