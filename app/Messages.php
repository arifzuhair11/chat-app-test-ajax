<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message'
    ];

    protected $with = ['sender', 'receiver'];

    /**
      *  Associate relationships
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id')->select(['id', 'name']);
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id')->select(['id', 'name']);
    }

    /**
      *  Create model scope for simplifying queries
     */
    public function scopeBySender($query, $sender)
    {
        $query->where('sender_id', $sender);
    }

    public function scopeByReceiver($query, $receiver)
    {
        $query->where('receiver_id', $receiver);
    }
}
