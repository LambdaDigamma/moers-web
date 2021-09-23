<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RadioBroadcast;
use Illuminate\Http\JsonResponse;

class RadioBroadcastController extends Controller
{
    public function index(): JsonResponse
    {
        $radioBroadcasts = RadioBroadcast::all();

        return new JsonResponse([
            'message' => 'Successfully loaded radio broadcasts.',
            'data' => $radioBroadcasts
        ]);
    }
}