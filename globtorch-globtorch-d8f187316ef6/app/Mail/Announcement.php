<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Announcement extends Mailable
{
    use Queueable, SerializesModels;

    protected $announcement;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($announcement)
    {
        $this->announcement = $announcement;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('media@globtorch.com', 'Globtorch')
                    ->subject('Announcement')
                    ->view('emails.announcement')
                    ->with([
                        'announcement'=>$this->announcement
                    ]);
    }
}
