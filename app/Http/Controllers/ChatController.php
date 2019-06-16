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
        $this->chatkit = app('ChatKit');
    }

    public function openChatRoom(Request $request)
    {
        // Get all auth user chats
        $chats = auth()->user()->chats()->get();
        
        // Loop through chats
        foreach ($chats as $chat) {
            // Check if auth user already has an open chat with the request user
            if($chat->users->contains($request->user)) {
                $roomId = $chat->room_id;
                return redirect()->route('showChat', $roomId);
            };
        }

        // Create a new chat room 
        $request = $this->chatkit->createRoom([
            'creator_id' => (string) auth()->id(),
            'name' => str_random(8),
            'user_ids' => [ (string) $request->user ],
            'private' => true,
        ]);

        $roomId = $request['body']['id'];
        
        // Save chat room id 
        $chat = Chat::create([
            'room_id' => $roomId,
        ]);
        
        // Attach users to the current chat
        $chat->users()->attach([
            auth()->id(), 
            $request->user
        ]);
       
        return redirect()->route('showChat', $roomId);
    }

    public function showChatRoom($id)
    {
        // Find chat 
        $chat = Chat::where('room_id', $id)->first();

        // Fetch the second user on this chat
        $user = $chat->users()->where('user_id', '!=', auth()->id() )->first();

        // Fetch chat messages via Chatkit
        $messages = $this->chatkit->fetchMultipartMessages([
            'room_id' => $id,
            'limit' => 100,
            'direction' => "newer",
          ]);
          
        return view('chat')->with([
            'user' => $user,
            'messages' => $messages,
        ]);
    }

    public function getMessages(Request $request)
    {

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
