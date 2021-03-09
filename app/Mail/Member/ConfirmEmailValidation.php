<?php

namespace App\Mail\Member;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

// Models
use App\Models\Member;

class ConfirmEmailValidation extends Mailable
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
        return $this->subject('Votre adresse e-mail confirmée')->view('emails/en/member/confirm_email_validation')->with(['user' => $this->user]);
    }
}
