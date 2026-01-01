<?php

namespace Modules\Multimedia\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Multimedia\Models\RadioBroadcast;

class RadioBroadcastController extends Controller
{
    public function index(): JsonResponse
    {
        $radioBroadcasts = RadioBroadcast::query()
            ->upcoming()
            ->get();

        return new JsonResponse([
            'message' => 'Successfully loaded radio broadcasts.',
            'data' => $radioBroadcasts,
        ]);
    }

    public function show(RadioBroadcast $radioBroadcast): JsonResponse
    {
        return new JsonResponse([
            'message' => 'Successfully loaded radio broadcast.',
            'data' => $radioBroadcast,
        ]);
    }
}
