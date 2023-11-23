<?php

namespace App\Http\Controllers\Api;

use Stripe\Stripe;
use App\Models\Product;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{

    /**
     * @return JsonResponse
     */
    public function showMyCart(): JsonResponse
    {
        $user = auth()->user();
        $cart = $user?->cart()->with("category")->get();
        return response()->json([
            'cart' => $cart,
            'total' => $cart->sum(function ($product) {
                return $product->price * $product->pivot->amount;
            }),
            'status' => 200,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addProductToCart(Request $request): JsonResponse
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'amount' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($user?->cart()->where('product_id', $request->input('product_id'))->exists()) {
            $productInCart = $user?->cart()->where('product_id', $request->input('product_id'))->first();
            $productInCart->pivot->amount += $request->input('amount');
            $productInCart->pivot->save();
        } else {
            $user?->cart()->attach(
                Product::findOrFail($request->input('product_id')),
                ['amount' => $request->input('amount')]
            );
        }

        return response()->json([
            'cart' => $user?->cart,
            'total' => $user?->cart->sum(function ($product) {
                return $product->price * $product->pivot->amount;
            }),
            'status' => 200,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function updateProductAmount(Request $request): JsonResponse
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'amount' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->input('amount') === 0) {
            $user->cart()->detach(Product::findOrFail($request->input('product_id')));
            return response()->json([
                'cart' => $user?->cart,
                'total' => $user?->cart->sum(function ($product) {
                return $product->price * $product->pivot->amount;
            }),
                'status' => 200,
            ]);
        }

        if ($user?->cart()->where('product_id', $request->input('product_id'))->exists()) {
            $productInCart = $user?->cart()->where('product_id', $request->input('product_id'))->first();
            $productInCart->pivot->amount = $request->input('amount');
            $productInCart->pivot->save();
        } else {
            $user?->cart()->attach(
                Product::findOrFail($request->input('product_id')),
                ['amount' => $request->input('amount')]
            );
        }

        return response()->json([
            'cart' => $user?->cart,
           'total' => $user?->cart->sum(function ($product) {
                return $product->price * $product->pivot->amount;
            }),
            'status' => 200,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function decrementProduct(Request $request): JsonResponse
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($user?->cart()->where('product_id', $request->input('product_id'))->exists()) {
            $productInCart = $user?->cart()->where('product_id', $request->input('product_id'))->first();
            --$productInCart->pivot->amount;
            $productInCart->pivot->save();
            if ($productInCart->pivot->amount === 0) {
                $user?->cart()->detach(Product::findOrFail($request->input('product_id')));
            }
        }

        return response()->json([
            'cart' => $user?->cart,
            'total' => $user?->cart->sum(function ($product) {
                return $product->price * $product->pivot->amount;
            }),
            'status' => 200,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function removeProduct(Request $request): JsonResponse
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user?->cart()->detach(Product::findOrFail($request->input('product_id')));

        return response()->json([
            'cart' => $user?->cart,
            'total' => $user?->cart->sum(function ($product) {
                return $product->price * $product->pivot->amount;
            }),
            'status' => 200,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function empty(Request $request): JsonResponse
    {
        $user = auth()->user();
        $user?->cart()->detach();
        return response()->json([
            'status' => 200,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkout(Request $request): JsonResponse
    {
        $user = auth()->user();
        Stripe::setApiKey(config('stripe.sk'));
        $customer = $user->createOrGetStripeCustomer();

        $allItems = $user?->cart;
        $lineItems = [];
        foreach ($allItems as $item) {
            // add the product to the line items array
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $item->price * $item->pivot->amount,
                    'product_data' => [
                        'name' => $item->name,
                    ],
                ],
                'quantity' => $item->pivot->amount,
            ];
        }

        $session = Session::create(
            [
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'customer' => $customer->id,
                'success_url' => $request->get('success_url'),
                'cancel_url' => $request->get('cancel_url'),
            ]
        );
        return response()->json([
            'status' => 200,
            'url' => $session->url,
        ]);
    }
}
