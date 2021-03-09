<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $hidden = ['created_at', 'updated_at', 'deleted_at', 'section_id', 'course_id', 'topic_id', 'user_id', 'order', 'channel_id'];
    protected $fillable = ['filename', 'user_id'];
    protected $append = ['sources'];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function live(){
        return $this->belongsTo(Live::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function topicName()
    {
        return $this->topic ? $this->topic->title : '';
    }

    public function videoqualities()
    {
        return $this->hasMany(Videoquality::class, 'video_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'video_id', 'id');
    }

    public function getNumberAttribute() {
        return $this->where('course_id', $this->course_id)
        ->where('published', 1)
        ->where('section_id', $this->section_id)
        ->where('order', '<', $this->order)
        ->count() + 1;
    }

    public function getVideoSourcesAttribute() {
        $sources = [];
        if($this->status == 'e') {
            $tmpSources = $this->videoqualities->toArray();
            foreach($tmpSources as $source) {
                $sources[] = [
                    'src' => $source['url'],
                    'type' => 'video/mp4',
                    'size' => $source['quality'],
                ];
            }
        } else {
            $sources[] = [
                'src' => $this->filename,
                'type' => 'video/mp4',
            ];
        }
        
        return [
            'type' => 'video',
            'title' => (String)$this->title,
            'poster' => (String)$this->thumbnail,
            'sources' => $sources,
        ];

    }

}
