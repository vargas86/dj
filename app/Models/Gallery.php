<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = ['path', 'user_id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at' , 'user_id'];
}
