<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = ['message', 'live_id', 'user_id'];

    protected function user(){
        return $this->belongsTo(User::class);
    }
}
