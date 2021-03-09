<?php

namespace App\Mail\Member;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App;

// Models
use App\Models\Member;

class RequestEmailValidation extends Mailable
{
    use Queueable, SerializesModels;

    protected $user ;
    protected $validation_url ;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Member $user, $validation_url)
    {
        //
        $this->user = $user ;
        $this->validation_url = $validation_url ;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->subject('Confirm your e-mail address')->view('emails/'.App::getLocale().'/member/request_email_validation')->with(['user' => $this->user, 'validation_url' => $this->validation_url]);
        return $this->subject('Confirm your e-mail address')->view('emails/en/member/request_email_validation')->with(['user' => $this->user, 'validation_url' => $this->validation_url]);

    }
}
