<?php

namespace App\Http\Controllers;

use App\Shop;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('entrust-gui.admin');
    }

    public function index() {

        $users = User::all();
        $shops = Shop::all();
        $bestUsers = DB::table('users')->orderBy('points', 'desc')->take(5)->get();
        $unvalidatedShops = Shop::all()->where('validated', '=', 0)->take(5);

        return view('admin.dashboard', [
            'users' => $users,
            'shops' => $shops,
            'bestUsers' => $bestUsers,
            'unvalidatedShops' => $unvalidatedShops
            ]);

    }

}
