<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class User extends \TCG\Voyager\Models\User implements MustVerifyEmail
{
    use SoftDeletes;
    use Notifiable;
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at', 'deleted_at', 'role_id', 'email_verified_at', 'school_location', 'settings', 'topic_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function channels()
    {
        return $this->hasMany(Channel::class, 'user_id', 'id');
    }

    public function channel()
    {
        return $this->channels()->first();
    }

    public function videos()
    {
        return $this->hasMany(Video::class, 'user_id', 'id')->where('course_id', null);
    }

    public function pack()
    {
        return $this->hasOne(Pack::class, 'user_id', 'id');
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'user_id', 'id')->where('path', 'like', '%full%');
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function topicName()
    {
        return ($topic = $this->topic) ? $topic->title : '';
    }

    public function getIsLiveAttribute($value)
    {
        return $this->lives()->where('live', true)->first() ? true : false;
    }

    public function lives()
    {
        return $this->hasMany(Live::class, 'user_id', 'id');
    }

    public function getAvatarAttribute($value)
    {
        if (!str_contains($value, 'http')) return url(($value));
        return $value;
    }

    public function getNameAttribute($value)
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'user_id', 'id')->where('actif', 1);
    }

    public function getSubscriberscountAttribute($value)
    {
        return $this->subscriptions()->count() + $this->channels()->first()->additional;
    }

    /**
     * Balance Total
     */
    public function getBalanceTotal() {
        $channel = $this->channels()->first();
        return ($channel) ? $channel->balance_total / 100 : 0;
    }

    /**
     * Balance Withdrawn
     */
    public function getBalanceWithdrawn() {
        $channel = $this->channels()->first();
        return ($channel) ? $channel->balance_withdrawn / 100 : 0;
    }

    /**
     * Balance Current
     */
    public function getBalanceCurrent() {
        $channel = $this->channels()->first();
        return ($channel) ? $channel->balance_current / 100 : 0;
    }

    /**
     * Balance Estimated incoming
     */
    public function getBalanceEstimated() {
        return $this->subscriptions()->where('actif', 1)->sum('price') * ((100 - env('THEDOJO_FEE_IN_PERCENT'))/100) / 100;
    }

    /**
     * Send Email Verification Notification
     *
     * @return App\Models\Member
     */
    public function sendEmailVerificationNotification()
    {
        // Delete user's tokens
        DB::table('email_validations')->where('email', '=', $this->email)->delete();

        // Token
        $token = Str::random(60);
        DB::table('email_validations')->insert([
            'email' => $this->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        try {
            $validation_url = route('user_confirm_email', ['email' => $this->email, 'token' => $token]) ;
            Mail::to($this->email)->send(new RequestEmailValidation($this, $validation_url));

        } catch (\Throwable $th) {
            
        }
        return $this;
    }
}
