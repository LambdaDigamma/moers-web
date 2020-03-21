<?php

namespace App\Broadcasting;

use App\Conversation;
use App\User;

class ConversationChannel
{
    /**
     * Authenticate the user's access to the channel.
     *
     * @param User         $user
     * @param Conversation $conversation
     *
     * @return array|bool
     */
    public function join(User $user, Conversation $conversation)
    {
        return $conversation->users->contains($user);
    }

}
