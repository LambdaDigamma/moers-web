<?php

namespace App\Http\Controllers;

use App\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{

    public function create() {

        return view('shops.create');

    }

    public function store(Request $request) {

        $input = $request->all();
        $user = $request->user();

        $this->validate($request, [
            'name' => 'required',
            'branch' => 'required',
            'street' => 'required',
            'house_number' => 'required',
            'postcode' => 'required|numerical',
            'place' => 'required',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric'
        ]);

        $shop = new Shop();


    }

}
