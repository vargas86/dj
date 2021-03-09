<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pack extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'channel_id', 'price',
    ];

    protected $hidden = [
        'user_id', 'channel_id', 'updated_at', 'created_at'
    ];
}
