<?php

namespace App\Models;

use App\Models\User;
use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    public function messages() {
        return $this->hasMany(Message::class);
    }

    public function conversationUsers() {
        return $this->hasMany(ConversationUser::class);
    }

    public static function getConversationByUserId($userId) {
        $conversationUser = ConversationUser::getConversationUserByUserId($userId);
        if (!count($conversationUser)) {
            return array();
        }
        $conversation = Conversation::where('id', '=', $conversationUser[0]->conversation_id)->get();
        if (count($conversation) > 0) {
            return $conversation;
        }
        return array();
    }

    public static function getMessageById($id) {
        return Message::where('conversation_id', '=', $id)->get();
    }
}
