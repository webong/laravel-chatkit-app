<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Chat;

class ChatController extends Controller
{
    protected $chatKit;

    public function __construct()
    {
        $this->middleware('auth');
        $this->chatKit = app('ChatKit');
    }

    public function openChatRoom(Request $request)
    {
        $chats = auth()->user()->chats()->get();
        
        foreach ($chats as $chat) {
            if($chat->users->contains($request->user)) {
                $roomId = $chat->room_id;
                return redirect()->route('showChat', $roomId);
            };
        }

        $request = $this->chatKit->createRoom([
            'creator_id' => (string) auth()->id(),
            'name' => str_random(8),
            'user_ids' => [ (string) $request->user ],
            'private' => true,
        ]);

        $roomId = $request['body']['id'];

        $chat = Chat::create([
            'room_id' => $roomId,
        ]);

        $chat->users()->attach([
            auth()->id(), 
            $request->user
        ]);
       
        return redirect()->route('showChat', $roomId);
    }

    public function showChatRoom($id)
    {
        return view('chat');
    }

    public function sendMessage(Request $request)
    {
        $this->chatKit->sendSimpleMessage([
            'sender_id' => (string) auth()->id(),
            'room_id' => (string) $request->room,
            'text' => $request->message
          ]);
    }

}
