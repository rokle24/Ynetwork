<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
    use HasFactory;

    // Mass assignable fields
    protected $fillable = [
        'user_id',
        'friend_id',
        'status',
    ];

    // Relationship to sender (user who sent the request)
    public function sender()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship to receiver (user who received the request)
    public function receiver()
    {
        return $this->belongsTo(User::class, 'friend_id');
    }
}
