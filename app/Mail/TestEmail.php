<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestEmail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $subject = 'Test de correo electrónico';

    public function __construct()
    {
        //
    }

    public function build()
    {
        return $this->view('emails.test-email-view');
    }
}
