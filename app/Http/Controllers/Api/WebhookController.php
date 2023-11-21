<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Controller;

class WebhookController extends Controller
{
    public function stripeWebhook(Request $request)
    {
        $token = config('stripe.webhook');
        Log::debug($token);
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
                $session = $event->data->object;
                Log::debug($session);
                break;
            default:
                echo 'Received unknown event type ' . $event->type;
        }
        return response()->json([], 200);
    }
}
