<?php

namespace App\Http\Controllers\API;

use App\Organisation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Auth;

class APIOrganisationController extends Controller
{

    public function __construct() {
        $this->middleware('auth:api')->except('get', 'show');
        $this->middleware('permission:create-organisation')->only('store');
        $this->middleware('permission:edit-organisation')->only('update');
        $this->middleware('permission:delete-organisation')->only('delete');
    }

    public function get() {
        return Organisation::with(['users', 'entry'])->get();
    }

    public function show($id) {

        $organisation = Organisation::with(['users', 'entry'])->findOrFail($id);

        return $organisation;
    }

    public function store(Request $request) {

        $organisation = Organisation::create($request->all());

        return response()->json($organisation, 201);

    }

    public function update(Request $request, Organisation $organisation) {

        $organisation->update($request->all());

        return response()->json($organisation, 200);

    }

    public function delete(Organisation $organisation) {

        try {
            $organisation->delete();
        } catch (Exception $e) {}

        return response()->json(null, 204);

    }

    public function join(Request $request, $id) {

        $userID = $request->user()->id;

        $organisation = Organisation::findOrFail($id);

        $organisation->users()->attach($userID);

        $organisation = Organisation::with(['users', 'entry'])->findOrFail($id);

        return response()->json($organisation, 200);

    }

    public function leave(Request $request, $id) {

        $userID = $request->user()->id;

        $organisation = Organisation::findOrFail($id);

        $organisation->users()->detach($userID);

        $organisation = Organisation::with(['users', 'entry'])->findOrFail($id);

        return response()->json($organisation, 200);

    }

}
