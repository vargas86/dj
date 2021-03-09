<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Videoquality extends Model
{
    protected $hidden = ['created_at', 'updated_at', 'video_id'];
}
