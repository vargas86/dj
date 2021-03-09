<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Topic extends Model
{
    use SoftDeletes;

    protected $hidden = ['topic_id', 'created_at', 'updated_at', 'deleted_at', 'disabled'];

    public static function boot()
    {
        parent::boot();
    }

    public function parent() {
        return $this->belongsTo('App\Models\Topic', 'topic_id');
    }

    public function child() {
        return $this->hasMany('App\Models\Topic')->where('disabled', false);
    }

    public function setTitleAttribute($value) {
        $this->attributes['slug'] = Str::slug($value, '-');
        $this->attributes['title'] = $value;
    }

    public function getAvatarAttribute($value) {
        return ($value) ? $value : 'images/default/topic.png' ;
    }

    public function getPathAttribute() {
        
        $parent = $this->parent;
        $url = $this->slug;

        while($parent) {
            $url = $parent->slug . '/' . $url;
            $parent = $parent->parent;
        }
        return $url ;
    }
    
}
