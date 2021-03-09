<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Channel extends Model
{
    use SoftDeletes;
    /**
     * Get the product associated with the cartitem.
     */
    protected $hidden = ['created_at', 'updated_at', 'deleted_at', 'user_id', 'pack_id', 'active'];
    protected $appends = ['courses_count', 'videos_count', 'subscriptions_count'];

    public function pack()
    {
        return $this->hasOne(Pack::class, 'id', 'pack_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'channel_id', 'id')->where('actif', 1);
    }

    public function getSubscriptionsCountAttribute()
    {
        return $this->subscriptions()->count() + $this->additional;
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function getCoursesCountAttribute()
    {
        return $this->courses()->where('published' , true)->count();
    }

    public function videos()
    {
        return $this->hasMany(Video::class)->where('course_id', null)->where('section_id' , null);
    }

    public function getVideosCountAttribute()
    {
        return $this->videos()->where('published', true)->count();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
