<?php

namespace Wator\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use Wator\Channels\WeiboChannel;


class WeiboParticipleNotification extends Notification
{
    use Queueable;
    
    public $url_;
    public $api_;
    protected $token_;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($url)
    {
        //
        $this->url_ = $url;
        $this->api_ = 'https://api.weibo.com/2/statuses/share.json';
        try {
            $this->token_ = file_get_contents('/opt/rsaauth/weibo/access_token');
        } catch( \Exception $e ) {
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [WeiboChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toWeibo($notifiable)
    {
        $this->postWeibo($this->url_);
    }

    public function postWeibo($text)
    {
        if($this->token_) {
            $options = JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_PRETTY_PRINT;
            $weiboJson = [
                'access_token' => $this->token_,
                'status' => $text
            ];
            $content = json_encode($weiboJson, $options);
            $opts['http'] = [
              'method' =>'POST',
              //'header' => 'Content-type: application/json',
              'content' => $content
            ];
            $context = stream_context_create($opts);
            file_get_contents($this->api_, false, $context);            
        }
    }
}
