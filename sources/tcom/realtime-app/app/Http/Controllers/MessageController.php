<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\jsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Events\PrivateMessageEvent;

class MessageController extends Controller
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
        $users = User::getUsersNotAuthenticated();
        $friendInfo = User::findOrFail($userId);
        $myInfo = User::getMyInfo();

        $this->data = array(
            'users' => $users,
            'friendInfo' => $friendInfo,
            'myInfo' => $myInfo,
        );

        return view('message.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $request->validate([
            'message' => 'required',
            'receiver_id' => 'required'
        ]);

        $sender_id = Auth::id();
        $receiver_id = $request->receiver_id;

        $message = new Message();
        $message->message = $request->message;
        $message->user_id = $sender_id;

        if ($message->save()) {
            try {
                $message->users()->attach($sender_id, ['receiver_id' => $receiver_id]);
                $sender = User::find($sender_id)->first();

                $data = array(
                    'sender_id' => $sender_id,
                    'sender_name' => $sender->name,
                    'receiver_id' => $receiver_id,
                    'content' => $message->message,
                    'created_at' => $message->created_at,
                    'message_id' => $message->id,
                );

                event(new PrivateMessageEvent($data));

                return response()->json([
                    'data' => $data,
                    'success' => true,
                    'message' => 'Message sent successfully'
                ]);
            } catch (\Exception $e) {
                $message->delete();
            }
        }
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
