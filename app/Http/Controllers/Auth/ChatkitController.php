<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChatkitController extends Controller
{
    private $chatkit;

    public function __construct()
    {
        $this->chatkit = app('ChatKit');
    }

    public function authenticate(Request $request)
    {
        $response = $this->chatkit->authenticate([
            'user_id' => $request->user_id,
        ]);

        return response()
        ->json(
            $response['body'],
            $response['status']
        );    
    }
}
