const redis = require("redis");
const redisOption = {
  port:6379,
  host:'127.0.0.1'
};
const sub = redis.createClient(redisOption);
sub.on('message', function(channel, message) {
  console.log('sub::channel=<',channel,'>');
  console.log('sub::message=<',message,'>');
});

sub.on('ready', function(channel, message) {
  console.log('sub::ready sub=<',sub,'>');
});

sub.on("subscribe", function (channel, count) {
  console.log('sub::subscribe channel=<',channel,'>');
  console.log('sub::subscribe count=<',count,'>');
});

sub.subscribe('wai.train.response');
