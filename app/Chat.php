<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $casts = [
        'members' => 'array'
    ];

    protected $fillable = ['room_id', 'members'];

    /**
     * Get the users for the chat.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
