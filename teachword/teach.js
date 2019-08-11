const redis = require("redis");
const redisOption = {
  port:6379,
  host:'127.0.0.1'
};
const SUB_CHANNEL = 'wai.teach.word.from.web'
const sub = redis.createClient(redisOption);
sub.on('message', (channel, message) => {
  console.log('sub::channel=<',channel,'>');
  console.log('sub::message=<',message,'>');
  let jsonMsg = JSON.parse(message);
  if(jsonMsg) {
    postWaiSNS(jsonMsg);
  }
});

sub.on('ready', (evt)=> {
  console.log('sub::ready evt=<',evt,'>');
});

sub.on("subscribe", (channel, count) => {
  console.log('sub::subscribe channel=<',channel,'>');
  console.log('sub::subscribe count=<',count,'>');
});

sub.subscribe(SUB_CHANNEL);

const WebSocket = require('ws');

const wss = new WebSocket.Server({
   port: 20080
});

wss.on('connection', (ws) =>{
  console.log('wss::connection ws=<',ws,'>');
});
