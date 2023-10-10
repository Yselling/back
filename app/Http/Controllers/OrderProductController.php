<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderProductRequest;
use App\Http\Resources\OrderProductResource;
use App\Models\OrderProduct;

class OrderProductController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', OrderProduct::class);

        return OrderProductResource::collection(OrderProduct::all());
    }

    public function store(OrderProductRequest $request)
    {
        $this->authorize('create', OrderProduct::class);

        return new OrderProductResource(OrderProduct::create($request->validated()));
    }

    public function show(OrderProduct $orderProduct)
    {
        $this->authorize('view', $orderProduct);

        return new OrderProductResource($orderProduct);
    }

    public function update(OrderProductRequest $request, OrderProduct $orderProduct)
    {
        $this->authorize('update', $orderProduct);

        $orderProduct->update($request->validated());

        return new OrderProductResource($orderProduct);
    }

    public function destroy(OrderProduct $orderProduct)
    {
        $this->authorize('delete', $orderProduct);

        $orderProduct->delete();

        return response()->json();
    }
}
