<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::getUsersNotAuthenticated();
        $this->data['users'] = $users;

        return view('chat', $this->data);
    }
}
