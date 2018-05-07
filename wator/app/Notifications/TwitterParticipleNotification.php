<?php

namespace Wator\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use NotificationChannels\Twitter\TwitterChannel;
use NotificationChannels\Twitter\TwitterStatusUpdate;

use App;
use Config;


class TwitterParticipleNotification extends Notification
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
        return [TwitterChannel::class];
    }

    public function toTwitter($notifiable)
    {
        $response = session('wai_participle_cut_reponse');
        $text = session('wai_participle_cut_text');
        try {
            $jsonRes = json_decode($response,true);
            $post = '' ;
            if (App::isLocale('ja')) {
                $post .= '#人工知能 #形態素解析 #自然言語処理 #NLP' ;
            } else {
                $post .= '#人工智能 #AI #中文分词 #自然语言处理 #NLP' ;
            }
            $post .= "\n" ;
            $post .= "\n" ;
            if (App::isLocale('ja')) {
                $post .= 'お試すリンク' ;
            } else {
                $post .= '你快来试试吧' ;
            }
            $post .= "\n" ;
            $post .= 'https://www.wator.xyz/wai/text/participle';
            $post .= "\n" ;
            $post .= "\n" ;
            $post .= "\n" ;
            $post .= "\n" ;
            $post .= $this->url_;
            return (new TwitterStatusUpdate($post));
        } catch (\Exception $e) {
            return new TwitterStatusUpdate($e->getMessage());
        }
    }
}
