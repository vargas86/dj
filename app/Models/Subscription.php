<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $hidden = ['user_id', 'pack_id', 'created_at', 'updated_at', 'channel_id'];

    public function Channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
