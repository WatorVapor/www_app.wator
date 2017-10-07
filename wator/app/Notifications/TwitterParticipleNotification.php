<?php

namespace Wator\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use NotificationChannels\Twitter\TwitterChannel;
use NotificationChannels\Twitter\TwitterStatusUpdate;


class TwitterParticipleNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TwitterChannel::class];
    }
    public function toTwitter($notifiable)
    {
        $response = session('wai_participle_cut_reponse');
        $text = session('wai_participle_cut_text');
        try {
            $jsonRes = json_decode($response,true);
            $post = '我分析了短语，你看对吗？' ;
            $post .= "\n" ;
            $post .= "\n" ;
            $post .= '原文如下：' ;
            $post .= "\n" ;
            $post .= "\n" ;
            $post .= $text;
            $post .= "\n" ;
            $post .= "\n" ;
            $post .= '分词结果：' ;
            $post .= "\n" ;
            $post .= "\n" ;
            foreach( $jsonRes['wai'] as $phase ) {
                $post .=  $phase['sentence'];
                $post .= "\n" ;
            }
            $post .= "\n" ;
            $post .= "\n" ;
            $post .= '快来试试吗' ;
            $post .= "\n" ;
            $post .= 'https://www.wator.xyz/wai/text/participle';
            return new TwitterStatusUpdate($post);
        } catch (\Exception $e) {
            return new TwitterStatusUpdate($e->getMessage());
        }
        
    }
}
