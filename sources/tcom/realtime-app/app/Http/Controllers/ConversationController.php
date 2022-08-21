<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\ConversationUser;
use Illuminate\Http\Request;
use App\Models\User;

class ConversationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($userId)
    {
        $this->data = array();
        $conversation = Conversation::getConversationByUserId($userId);
        $users = User::getUsersNotAuthenticated();
        $friendInfo = User::findOrFail($userId);
        $myInfo = User::getMyInfo();
        if (!count($conversation)) {
            $conversation = new Conversation();
            $conversation->save();
            $conversationUser = new ConversationUser();
            $conversationUser->conversation_id = $conversation->id;
            $conversationUser->user_id = $userId;
            $conversationUser->sender_id = auth()->user()->id;
            $conversationUser->receiver_id = $userId;
            $conversationUser->save();
        }
        $this->data = array(
            'users' => $users,
            'friendInfo' => $friendInfo,
            'myInfo' => $myInfo,
        );

        return view('conversation.index ', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
