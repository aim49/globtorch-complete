<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserNotifications extends Notification
{
    use Queueable;

    protected $subject, $introduction, $notification_action, $notification_url, $conclusion;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($subject, $introduction, $notification_action, $notification_url, $conclusion)
    {
        $this->subject = $subject;
        $this->introduction = $introduction;
        $this->notification_action = $notification_action;
        $this->notification_url = $notification_url;
        $this->conclusion = $conclusion;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->from('media@globtorch.com', 'Globtorch Online Education')
                    ->subject($this->subject)
                    ->line($this->introduction)
                    ->action($this->notification_action, url($this->notification_url))
                    ->line($this->conclusion);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
