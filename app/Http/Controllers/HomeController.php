<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;

class HomeController extends Controller
{
    protected $chatkit;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application chat room.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() 
    {
        $chatkit = app('ChatKit');
        $roomId = (string) env('CHATKIT_GENERAL_ROOM_ID');
        $userId = (string) auth()->user()->chatkit_id;
    
        // Get messages via Chatkit
        $fetchMessages = $chatkit->getRoomMessages([
            'room_id' => $roomId,
            'direction' => 'newer',
            'limit' => 100
        ]);

        $messages = collect($fetchMessages['body'])->map(function ($message) {
            return [
                'id' => $message['id'],
                'senderId' => $message['user_id'],
                'text' => $message['text'],
                'timestamp' => $message['created_at']
            ];
        });

        return view('home')->with(compact('messages', 'roomId', 'userId'));
    }
}
