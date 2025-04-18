<?php

namespace Devadze\FlittPayment\Http\Controllers;

use Devadze\FlittPayment\Events\PaymentReceived;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CallbackController extends Controller
{
    const ALLOWED_IPS = [
        '54.154.216.60',
        '3.75.125.89'
    ];

    public function __invoke(Request $request): JsonResponse
    {
        if (!in_array($request->ip(), self::ALLOWED_IPS)){
            abort(404);
        }

        $response = json_decode($request->getContent(), true);

        event(new PaymentReceived($response));

        return response()->json(['message' => 'HTTP/1.1 200 Ok'], 200);
    }
}
