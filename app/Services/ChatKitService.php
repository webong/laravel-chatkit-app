<?php
namespace App\Services;

use Chatkit\Chatkit;

class ChatKitService 
{
    protected $chatkit;

    public function __construct()
    {
        $this->chatkit = new Chatkit([
            'instance_locator' => config('services.chatkit.locator'),
            'key' => config('services.chatkit.secret'),
        ]);
    }

    // public function __call($method, $args)
    // {
    //     return $this->chatkit->$method($args);
    // }

}