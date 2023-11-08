<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentMail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $subject = '';
    public $data;

    public function __construct($data, $subject)
    {
        $this->data = $data;
        $this->subject = $subject;
    }

    public function build()
    {
        $state = $this->data['state'] ?? 0;
        if($state == 1){
            return $this->view('emails.approve-event');
        }else if($state == 2){
            return $this->view('emails.reject-event');
        }else{
            return $this->view('emails.new-event');
        }
    }
}
