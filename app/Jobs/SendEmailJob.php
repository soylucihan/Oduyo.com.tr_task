<?php
 
namespace App\Jobs;
 
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\SendEmailTest;
use Illuminate\Support\Facades\Mail;
 
class SendEmailJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
 
  protected $details;
 
  public function __construct($details)
  {
      $this->details = $details;
  }
 
  public function handle()
  {
      // Create a new instance of the SendEmailTest class and pass in the details
      $email = new SendEmailTest($this->details);
  
      // Use the Mail facade to send the email
      // The 'to' method specifies the recipient's email address
      // The 'send' method sends the email using the SendEmailTest instance
      Mail::to($this->details['email'])->send($email);

  }
  
}
