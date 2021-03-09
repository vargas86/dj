<?php

namespace App\Mail\Member;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

// Models
use App\Models\Member;

class ConfirmPasswordChange extends Mailable
{
    use Queueable, SerializesModels;

    protected $user ;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Member $user)
    {
        //
        $this->user = $user ;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Changement de mot de passe')->view('emails/en/member/confirm_password_change')->with(['user' => $this->user]);
    }
}
