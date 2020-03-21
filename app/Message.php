<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'conversation_id',
        'sender_id',
        'content',
    ];

    /**
     * Conversation associated to this message.
     *
     * @return BelongsTo
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * Sender of the message.
     *
     * @return BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

}
