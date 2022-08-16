<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConversationUser extends Model
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

    public static function getConversationUserByUserId($userId) {
        $conversationUser = ConversationUser::where('user_id', '=', $userId)->get();
        if (count($conversationUser) > 0) {
            return $conversationUser;
        }
        return array();
    }
}
