<?php

namespace Wator\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;


class FacebookParticipleNotification extends Notification
{
    use Queueable;
    public $url_;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($url)
    {
        //
        $this->url_ = $url;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [FacebookChannel::class];
    }
    public function toFacebook($notifiable){
        return FacebookMessage::create('You have just paid your monthly fee! Thanks')->to($this->user->fb_messenger_id);
    }
}
