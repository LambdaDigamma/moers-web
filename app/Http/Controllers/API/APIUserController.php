<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class APIUserController extends Controller
{

    public function getUser(Request $request) {

        return $request->user();

    }

}
