<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;

class CartController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Cart::class);

        return CartResource::collection(Cart::all());
    }

    public function store(CartRequest $request)
    {
        $this->authorize('create', Cart::class);

        return new CartResource(Cart::create($request->validated()));
    }

    public function show(Cart $cart)
    {
        $this->authorize('view', $cart);

        return new CartResource($cart);
    }

    public function update(CartRequest $request, Cart $cart)
    {
        $this->authorize('update', $cart);

        $cart->update($request->validated());

        return new CartResource($cart);
    }

    public function destroy(Cart $cart)
    {
        $this->authorize('delete', $cart);

        $cart->delete();

        return response()->json();
    }
}
