<?php

namespace Cachet\Http\Controllers\StatusPage;

use Cachet\Actions\Subscriber\CreateSubscriber;
use Cachet\Models\Subscriber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SubscriberController extends Controller
{
    /**
     * Handle subscriber creation from the status page.
     */
    public function subscribe(Request $request, CreateSubscriber $createSubscriber): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        $existing = Subscriber::where('email', $request->input('email'))->first();

        if ($existing) {
            return response()->json([
                'success' => true,
                'already_subscribed' => true,
                'message' => 'You are already subscribed to notifications.',
            ]);
        }

        $createSubscriber->handle(
            email: $request->input('email'),
            global: true,
        );

        return response()->json([
            'success' => true,
            'already_subscribed' => false,
            'message' => 'You have been subscribed to notifications.',
        ]);
    }
}
