<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Course extends Model
{
    protected $hidden = ['created_at', 'video', 'updated_at', 'deleted_at', 'visible', 'channel_id', 'topic_id', 'user_id', 'videos_count'];

    protected $appends = ['videos_count'];

    public function sections()
    {
        return $this->hasMany(Section::class)->where('published', 1)->orderBy('order');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class, 'course_id', 'id');
    }

    public function video()
    {
        return $this->section() ? $this->videos()->where('published', true)->where('section_id', $this->section()->id)->orderBy('order', 'ASC')->first() : null;
    }
    public function section()
    {
        return $this->sections()->orderBy('order', 'ASC')->first();
    }

    public function getVideosCountAttribute()
    {
        return $this->videos()->where('published', true)->count();
    }

    public function duration()
    {
        return $this->videos()->sum('duration');
    }

    public function getDurationAttribute()
    {
        $seconds = $this->videos()->where('course_id', '=', $this->id)->where('published', '=', 1)->sum(DB::raw("TIME_TO_SEC(duration)"));
        $duration = gmdate("H:i:s", $seconds);
        return $duration;
    }

    public function publishedSections()
    {
        return $this->sections()->where('published', true)->orderBy('order', 'ASC')->get();
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function getTopicnameAttribute()
    {
        if($this->topic){
            return $this->topic->title;
        }
    }
}
