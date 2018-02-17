const WebSocket = require('ws');
const config = {host:'127.0.01', port: 19082 }
const wss = new WebSocket.Server(config);
wss.on('connection', function connection(ws) {
  ws.on('message', function incoming(message) {
    console.log('received: message=<', message,'>');
    let jsonMsg = JSON.parse(message);
    if(jsonMsg) {
      if(jsonMsg.channel && jsonMsg.msg) {
        setTimeout(function() {
          if(pub) {
            pub.publish(jsonMsg.channel,JSON.stringify(jsonMsg.msg));
          }
        },1);
      }
    }
  });
});

const redis = require("redis");
const sub = redis.createClient();
sub.on('message', function(channel, message) {
  console.log('sub::channel=<',channel,'>');
  console.log('sub::message=<',message,'>');
  console.log('sub::wss=<',wss,'>');
  wss.clients.forEach(function each(client) {
    if (client.readyState === WebSocket.OPEN) {
      client.send(message);
    }
  })
});
sub.subscribe("wator/wai/webapp/notify");


const pub  = redis.createClient();
