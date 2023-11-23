<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\User;
use Stripe\StripeClient;
use Illuminate\Http\Request;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class WebhookController extends Controller
{
    public function stripeWebhook(Request $request)
    {
        $token = config('stripe.webhook');
        try {
            $payload = @file_get_contents('php://input');
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $request->header('Stripe-Signature', 'default'),
                $token
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response()->json([], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            Log::debug('Invalid signature');
            return response()->json([], 401);
        };

        switch ($event->type) {
            case 'checkout.session.completed':
                $stripe = new StripeClient(config('stripe.sk'));

                $session = $event->data->object;
                $user = User::where('stripe_id', $session->customer)->firstOrFail();
                // create a transactrion to add an order to the user and empty the cart
                $order = new Order();
                $order->user()->associate($user);
                $order->orderState()->associate(2);
                $order->save();
                foreach ($user->cart()->get() as $product) {
                    Log::debug($product);
                    $order->products()->attach($product, ['amount' => $product->pivot->amount, 'order_id' => $order->id]);
                }
                $user->cart()->detach();
                break;
            default:
                echo 'Received unknown event type ' . $event->type;
        }
        return response()->json([], 200);
    }
}
