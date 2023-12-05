<?php
namespace App\Mail;

use Illuminate\Mail\Mailable;

class SendEmailTest extends Mailable
{
    public $details;
    public function __construct($details)
    {
        $this->details = $details;
    }
    public function build()
{
    return $this->from('cihan@deepol.uz') // Set the sender email address
                ->subject('Welcome') // Set the email subject
                ->view('mail')->with($this->details); // Set the email body using a view template and pass data to the view
}
}