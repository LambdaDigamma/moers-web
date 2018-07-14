<?php

namespace App\Http\Controllers;

use App\Shop;
use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('entrust-gui.admin');
    }

    public function index() {

        $users = User::all();
        $shops = Shop::all();

        return view('admin', ['users' => $users, 'shops' => $shops]);

    }

}
