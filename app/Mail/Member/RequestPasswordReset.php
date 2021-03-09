<?php

namespace App\Mail\Member;

use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;

// Models
use Illuminate\Queue\SerializesModels;

class RequestPasswordReset extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Member $user, $token)
    {
        //
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Password reset request.')->view('emails/en/member/request_password_reset')->with(['user' => $this->user, 'token' => $this->token]);
    }
}
