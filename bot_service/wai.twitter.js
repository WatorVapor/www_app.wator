const redis = require("redis");
const redisOption = {
  port:6379,
  host:'127.0.0.1'
};
const sub = redis.createClient(redisOption);
sub.on('message', function(channel, message) {
  console.log('sub::channel=<',channel,'>');
  console.log('sub::message=<',message,'>');
  let jsonMsg = JSON.parse(message);
  if(jsonMsg) {
    postWaiSNS(jsonMsg);
  }
});

sub.on('ready', function(evt) {
  console.log('sub::ready evt=<',evt,'>');
});

sub.on("subscribe", function (channel, count) {
  console.log('sub::subscribe channel=<',channel,'>');
  console.log('sub::subscribe count=<',count,'>');
});

sub.subscribe('wai.train.response');

const request = require('request');

function postWaiSNS(msg) {
  let options = {
    uri: "https://www.wator.xyz/wai/text/participle/sns",
    headers: {
      "Content-type": "application/json",
    },
    json: msg
  };
  request.post(options, function(error, response, body){
    console.log('postWaiSNS error=<',error,'>');
    //console.log('postWaiSNS response=<',response,'>');
    console.log('postWaiSNS body=<',body,'>');
  });
}
