<?php

namespace Wator\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Wator\Notifications\TwitterParticipleNotification;

class WaiRedisNotify extends Command
{
    use Notifiable;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        Redis::subscribe(['wai.train.response'], function ($message) {
            $jsonRes = json_decode($message,true);
            //var_dump($jsonRes);
            $data = ['result'=>$jsonRes['wai']];
            $staticHTML = view('wai.snsbot',$data)->__toString();
            $htmlFileName = hash('sha256',$staticHTML) . '.html';
            file_put_contents('/autogen/wator/wai/static/' . $htmlFileName,$staticHTML);
            $url_sns = 'https://www.wator.xyz//autogen/wai/static/' . $htmlFileName;
            $notify = $this->notify(new TwitterParticipleNotification($url_sns));
        });
    }
}
