<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    public function conversations() {
        return $this->belongsTo(Conversation::class);
    }

    public function users() {
        return $this->belongsToMany(User::class, 'conversation_users', 'conversation_id', 'user_id',
            'message_id', 'sender_id')
            ->withTimestamps();
    }
}
