<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenderRequest;
use App\Http\Resources\GenderResource;
use App\Models\Gender;

class GenderController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Gender::class);

        return GenderResource::collection(Gender::all());
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
