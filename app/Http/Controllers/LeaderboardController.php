<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaderboardController extends Controller
{
    public function topUser()
    {
        $users = User::orderBy('points', 'DESC')->select('id', 'name', 'points')->take(20)->get();

        foreach ($users as $key => $user) {
            $user['rank'] = $key + 1;
        }

        return $users;
    }

    public function userRanking()
    {
        $id = Auth::user()->id;

        $user_ids = User::orderBy('points', 'DESC')->pluck('id')->toArray();

        $rank = array_search($id, $user_ids);

        $user = Auth::user();

        $user['rank'] = $rank + 1;

        return $user;
    }
}
