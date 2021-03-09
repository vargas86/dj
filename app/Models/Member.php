<?php

namespace App\Models;

use App\Mail\Member\RequestEmailValidation;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

// Mails
use TCG\Voyager\Models\Role;

class Member extends User
{
    use Notifiable;
    //
    protected $table = 'users';

    protected $attributes = array(
        'role_id' => 3,
    );

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'phone', 'email', 'password',
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('author', function (\Illuminate\Database\Eloquent\Builder $builder) {
            $role = Role::where('name', '=', 'member')->first();
            if ($role) {
                $builder->where('role_id', '=', $role->id);
            } else {
                // abort(500);
            }
        });
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

        $validation_url = route('user_confirm_email', ['email' => $this->email, 'token' => $token]) ;

        Mail::to($this->email)->send(new RequestEmailValidation($this, $validation_url));

        return $this;
    }
}
