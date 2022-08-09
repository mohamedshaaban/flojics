<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApplicationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $application;
    public $vacancy;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($application,$vacancy)
    {
        $this->application = $application;
        $this->vacancy = $vacancy;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Job Application Form Submission')->view('emails.applicationEmail');
    }
}
