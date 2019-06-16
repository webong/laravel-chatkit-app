<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Chat;
use App\User;
class ChatController extends Controller
{
    protected $chatKit;

    public function __construct()
    {
        $this->middleware('auth');
        $this->chatkit = app('ChatKit');
    }

    public function openChat(Request $request)
    {
        // Get all auth user chats
        $chats = auth()->user()->chats()->get();

        // Loop through chats
        foreach ($chats as $chat) {
            // Check if auth user already has an open chat with the request user
            if ($chat->users->contains($request->user)) {
                $roomId = $chat->room_id;
                return redirect()->route('showChat', $roomId);
            };
        }

        // Create a new chat room 
        $room = $this->chatkit->createRoom([
            'creator_id' => (string)auth()->id(),
            'name' => str_random(8),
            'user_ids' => [(string)$request->user],
            'private' => true,
        ]);

        $roomId = $room['body']['id'];

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

    public function showChat(Request $request, $id)
    {
        // Find chat 
        $chat = Chat::where('room_id', $id)->first();

        // All users
        $users = $chat->users()->get();

        // Fetch the other user on this chat
        $user = $chat->users()->where('user_id', '!=', auth()->id())->first();

        // Fetch chat messages via Chatkit
        $fetchMessages = $this->chatkit->fetchMultipartMessages([
            'room_id' => $id,
            'limit' => 100,
            'direction' => "newer",
        ]);
        
        $messages = collect($fetchMessages['body'])->map(function ($message) use ($users) {
            return [
                'id' => $message['id'],
                'text' => $message['parts'][0]['content'],
                'sender' => $users->where('id', (int) $message['user_id'])->first()->name,
            ];
        });

        if($request->ajax()){
            return $messages;
        }

        return view('chat')->with([
            'room' => $id,
            'user' => $user,
            'messages' => $messages,
        ]);
    }

    public function sendMessage(Request $request, $id)
    {
        return $this->chatkit->sendSimpleMessage([
            'sender_id' => (string)auth()->id(),
            'room_id' => (string)$id,
            'text' => $request->message
        ]);
    }
}
