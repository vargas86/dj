<?php

namespace App\Mail\Subscriptions;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UnSubscriptionStudent extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $lastname;
    public $firstname;
    public $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $firstname, $lastname, $message)
    // public function __construct()
    {
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
            ->subject('You have unsubscribed to ' . $this->firstname . ' ' . $this->lastname)
            ->with([
                'msg' => $this->message,
                'firstname' => $this->firstname,
                'lastname' => $this->lastname,
                'email' => $this->email,
            ])
            ->view('emails/unsubscription_student');
    }
}
