<?php

namespace Wator\Channels;

use Illuminate\Notifications\Notification;

class WeiboChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toWeibo($notifiable);

        // Send notification to the $notifiable instance...
    }
}
