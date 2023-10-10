<?php

namespace App\Http\Controllers;

use App\Http\Requests\MediaRequest;
use App\Http\Resources\MediaResource;
use App\Models\Media;

class MediaController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Media::class);

        return MediaResource::collection(Media::all());
    }

    public function store(MediaRequest $request)
    {
        $this->authorize('create', Media::class);

        return new MediaResource(Media::create($request->validated()));
    }

    public function show(Media $media)
    {
        $this->authorize('view', $media);

        return new MediaResource($media);
    }

    public function update(MediaRequest $request, Media $media)
    {
        $this->authorize('update', $media);

        $media->update($request->validated());

        return new MediaResource($media);
    }

    public function destroy(Media $media)
    {
        $this->authorize('delete', $media);

        $media->delete();

        return response()->json();
    }
}
