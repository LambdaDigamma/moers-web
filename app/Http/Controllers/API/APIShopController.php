<?php

namespace App\Http\Controllers\API;

use App\Shop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class APIShopController extends Controller
{

    public function getShops() {

        return Shop::where('validated', '=', '1')->get();

    }

    public function store(Request $request) {

        $inputs = $request->all();

        $shop = new Shop();

        $shop->name = $inputs['name'];
        $shop->branch = $inputs['branch'];
        $shop->street = $inputs['street'];
        $shop->house_number = $inputs['house_number'];
        $shop->postcode = $inputs['postcode'];
        $shop->place = $inputs['place'];
        $shop->lat = $inputs['lat'];
        $shop->lng = $inputs['lng'];
        $shop->url = $inputs['url'];
        $shop->phone = $inputs['phone'];
        $shop->monday = $inputs['monday'];
        $shop->tuesday = $inputs['tuesday'];
        $shop->wednesday = $inputs['wednesday'];
        $shop->thursday = $inputs['thursday'];
        $shop->friday = $inputs['friday'];
        $shop->saturday = $inputs['saturday'];
        $shop->sunday = $inputs['sunday'];
        $shop->other = $inputs['other'];

        $shop->creator_id = $request->user()->id;
        $shop->save();

        return response()->json($shop, 201);

    }

}
