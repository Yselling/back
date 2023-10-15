<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenderRequest;
use App\Http\Resources\GenderResource;
use App\Models\Gender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GenderController extends Controller
{

    public function index(Request $request)
    {
        $cacheKey = 'genders-index';

        $data = Cache::remember($cacheKey, now()->addHour(), function () {
            return GenderResource::collection(Gender::all());
        });

        return response()->json([
            'data' => $data,
            'count' => count($data),
            'message' => 'Success',
            'status' => 200,
        ]);
    }

    public function store(GenderRequest $request)
    {
        $this->authorize('create', Gender::class);

        return new GenderResource(Gender::create($request->validated()));
    }

    public function show(Gender $gender)
    {
        $this->authorize('view', $gender);

        return new GenderResource($gender);
    }

    public function update(GenderRequest $request, Gender $gender)
    {
        $this->authorize('update', $gender);

        $gender->update($request->validated());

        return new GenderResource($gender);
    }

    public function destroy(Gender $gender)
    {
        $this->authorize('delete', $gender);

        $gender->delete();

        return response()->json();
    }
}
