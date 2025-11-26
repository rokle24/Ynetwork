<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table = 'messages';

    protected $fillable = ['user_from', 'user_to', 'message', 'is_read'];

    public function sender()
    {
        return $this->belongsTo(User::class, 'user_from', 'id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'user_to', 'id');
    }
}
