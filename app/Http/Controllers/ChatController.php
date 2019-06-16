<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    protected $chatKit;

    public function __construct()
    {
        $this->chatKit = app('ChatKit');
    }

    public function createRoom(Request $request)
    {
        //
    }

    public function showRoom($id)
    {
        //
    }

    public function sendMessage(Request $request, $id)
    {
        $this->chatKit->sendSimpleMessage([
            'sender_id' => 'sarah',
            'room_id' => '1001',
            'text' => 'This is a wonderful message.'
          ]);
    }

}
