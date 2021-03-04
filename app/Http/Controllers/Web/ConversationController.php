<?php


namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use Auth;
use Carbon\Carbon;

class ConversationController extends Controller
{
    public function sendReadMessage(Conversation $conversation)
    {
        return $conversation->users()->updateExistingPivot(Auth::id(), ['last_active' => Carbon::now(), 'is_unread' => false]);
    }
}
