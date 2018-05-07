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
sub.subscribe('wai.train.response');

