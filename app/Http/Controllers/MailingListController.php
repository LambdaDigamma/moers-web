<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Newsletter;

class MailingListController extends Controller {

    public function subscribe(Request $request) {

        $input = $request->all();
        $email = $input['email'];

        if (!Newsletter::isSubscribed($email)) {

            Newsletter::subscribe($email);

        }

        return redirect()->route('index');

    }

}
