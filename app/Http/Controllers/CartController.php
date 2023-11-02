<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function showMyCart()
    {
        $user = auth()->user();

        $cart = $user->cart()->with("category")->get();

        return response()->json([
            'cart' => $cart,
            'total' => $cart->sum(function ($product) {
                return $product->price * $product->pivot->amount;
            }),
            'status' => 200,
        ]);
    }

    // add a new product to the cart, if the product already exists in the cart, increment the amount
    public function addProductToCart(Request $request)
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'amount' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($user->cart()->where('product_id', $request->input('product_id'))->exists()) {
            $productInCart = $user->cart()->where('product_id', $request->input('product_id'))->first();
            $productInCart->pivot->amount += $request->input('amount');
            $productInCart->pivot->save();
        } else {
            $user->cart()->attach(
                Product::findOrFail($request->input('product_id')),
                ['amount' => $request->input('amount')]
            );
        }

        return response()->json([
            'cart' => $user->cart,
            'total' => $user->cart->sum(function ($product) {
                return $product->price * $product->pivot->amount;
            }),
            'status' => 200,
        ]);
    }

    // save the request quantity of the product directly in the cart, no increment, no decrement
    public function updateProductAmount(Request $request)
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'amount' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->input('amount') == 0) {
            $user->cart()->detach(Product::findOrFail($request->input('product_id')));
            return response()->json([
                'cart' => $user->cart,
                'total' => $user->cart->sum(function ($product) {
                return $product->price * $product->pivot->amount;
            }),
                'status' => 200,
            ]);
        }

        if ($user->cart()->where('product_id', $request->input('product_id'))->exists()) {
            $productInCart = $user->cart()->where('product_id', $request->input('product_id'))->first();
            $productInCart->pivot->amount = $request->input('amount');
            $productInCart->pivot->save();
        } else {
            $user->cart()->attach(
                Product::findOrFail($request->input('product_id')),
                ['amount' => $request->input('amount')]
            );
        }

        return response()->json([
            'cart' => $user->cart,
           'total' => $user->cart->sum(function ($product) {
                return $product->price * $product->pivot->amount;
            }),
            'status' => 200,
        ]);
    }

    public function decrementProduct(Request $request)
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($user->cart()->where('product_id', $request->input('product_id'))->exists()) {
            $productInCart = $user->cart()->where('product_id', $request->input('product_id'))->first();
            $productInCart->pivot->amount -= 1;
            $productInCart->pivot->save();
        }

        if ($productInCart->pivot->amount == 0) {
            $user->cart()->detach(Product::findOrFail($request->input('product_id')));
        }

        return response()->json([
            'cart' => $user->cart,
            'total' => $user->cart->sum(function ($product) {
                return $product->price * $product->pivot->amount;
            }),
            'status' => 200,
        ]);
    }

    public function removeProduct(Request $request)
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user->cart()->detach(Product::findOrFail($request->input('product_id')));

        return response()->json([
            'cart' => $user->cart,
            'total' => $user->cart->sum(function ($product) {
                return $product->price * $product->pivot->amount;
            }),
            'status' => 200,
        ]);
    }


    public function empty(Request $request)
    {
        $user = auth()->user();

        $user->cart()->detach();

        return response()->json([
            'status' => 200,
        ]);
    }

}
