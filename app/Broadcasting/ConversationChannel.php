<?php

namespace App\Broadcasting;

use App\Models\Conversation;
use App\Models\User;

class ConversationChannel
{
    /**
     * Authenticate the user's access to the channel.
     *
     * @param \App\Models\User $user
     * @param Conversation     $conversation
     *
     * @return array|bool
     */
    public function join(User $user, Conversation $conversation)
    {
        return $conversation->users->contains($user);
    }

}
