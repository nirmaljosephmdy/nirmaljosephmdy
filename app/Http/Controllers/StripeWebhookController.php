<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Support\ApiResponse;
class StripeWebhookController extends Controller
{
    public function handle(Request $request, \App\Services\SubscriptionService $service)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sigHeader, $endpointSecret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return ApiResponse::error('Invalid payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return ApiResponse::error('Invalid signature', 400);
        }

        try {
            $service->handleWebhook(['type' => $event->type, 'data' => ['object' => $event->data->object->toArray()]]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Webhook handling error: ' . $e->getMessage());
            return ApiResponse::error('Error processing webhook', 500);
        }

        return ApiResponse::success(null, 'Webhook processed');
    }
}