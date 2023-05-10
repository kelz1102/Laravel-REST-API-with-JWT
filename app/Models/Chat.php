<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'chat_id',
    ];


    public function user1()
    {
        return $this->belongsTo(User::class, 'chat_id');
    }
    public function user2()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
