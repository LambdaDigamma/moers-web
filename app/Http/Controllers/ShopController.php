<?php

namespace App\Http\Controllers;

use App\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{

    public function __construct()
    {
        
    }

    public function index() {

        $shops = DB::table('shops')->paginate(10);

        return view('admin.shops.index', ['shops' => $shops]);

    }

    public function create() {

        $shop = new Shop();

        return view('admin.shops.create', ['shop' => $shop]);

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

//        $input = $request->all();
//        $user = $request->user();
//
//        $this->validate($request, [
//            'name' => 'required',
//            'branch' => 'required',
//            'street' => 'required',
//            'house_number' => 'required',
//            'postcode' => 'required|numerical',
//            'place' => 'required',
//            'lat' => 'required|numeric',
//            'lng' => 'required|numeric'
//        ]);
//
//        $shop = new Shop();
//

    }

    public function edit($id) {

        $shop = Shop::find($id);

        return view('admin.shops.edit', ['shop' => $shop]);

    }

    public function update($id, Request $request) {

        $inputs = $request->all();





        Shop::find($id)->update($inputs);

        return redirect()->route('shops.index')->with('success', 'Shop edited successfully');

    }

    public function destroy($id) {

        Shop::find($id)->delete();

        return redirect()->route('shops.index')->with('success', 'Shop deleted successfully');

    }

    public function approve($id) {

        $shop = Shop::find($id);

        $shop->validated = true;
        $shop->save();

        $points = 0;

        if($shop->name)



        return redirect()->route('admin')->with('success', 'Shop ' . $shop->name . ' approved successfully');

    }

    public function reject($id) {

        $shop = Shop::find($id);

        $shop->validated = false;
        $shop->save();

        return redirect()->route('admin')->with('success', 'Shop ' . $shop->name . ' rejected successfully');

    }

}
