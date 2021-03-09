<?php

namespace App\Mail\Member;

use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;

// Models
use Illuminate\Queue\SerializesModels;

class ConfirmPasswordReset extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Member $user)
    {
        //
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Changement de mot de passe')->view('emails/en/member/confirm_password_reset')->with(['user' => $this->user]);
    }
}
