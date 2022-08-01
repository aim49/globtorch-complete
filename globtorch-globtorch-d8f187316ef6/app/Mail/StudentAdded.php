<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class StudentAdded extends Mailable
{
    use Queueable, SerializesModels;

    protected $user_id, $password;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_id, $password)
    {
        $this->user_id = $user_id;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('media@globtorch.com', 'Globtorch')
                    ->subject('Your login credentials')
                    ->view('emails.student_added')
                    ->with([
                        'user_id'=>$this->user_id,
                        'password'=>$this->password
                    ]);
    }
}
