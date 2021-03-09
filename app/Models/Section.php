<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $hidden = ['created_at', 'updated_at', 'deleted_at', 'course_id', 'order', 'visible'];

    public function videos()
    {
        return $this->hasMany(Video::class)->where('published', 1)->orderBy('order');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
