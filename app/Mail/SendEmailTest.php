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
        return $this->from('cihan@deepol.uz') 
                    ->subject('Welcome')
                    ->view('mail')->with($this->details);
    }
}