<?php

namespace App\Http\Controllers;

use App\Shop;
use Illuminate\Http\Request;

class PortalController extends Controller
{

    public function menu() {

        return view('portal.menu');

    }

    public function index() {

        $shops = Shop::all();

        return view('portal.index')->with('shops', $shops);

    }

}
