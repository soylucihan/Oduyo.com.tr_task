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
      $email = new SendEmailTest($this->details);
      Mail::to($this->details['email'])->send($email->from('cihan@deepol.uz'));
  }
  
}
