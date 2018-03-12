const WebSocket = require('ws');
const config = {host:'127.0.0.1', port: 19082 }
const wss = new WebSocket.Server(config);
wss.on('connection', function connection(ws) {
    
  ws.on('message', function incoming(message) {
    //console.log('received: message=<', message,'>');
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
    
  ws.on('error', function (evt) {
    console.log('error: evt=<', evt,'>');
  });

  ws.isAlive = true;
  ws.on('pong', heartbeat);
});

function noop() {}
function heartbeat() {
  this.isAlive = true;
}

const interval = setInterval(function ping() {
  wss.clients.forEach(function each(ws) {
    if (ws.isAlive === false) {
      return ws.terminate();
    }
    ws.isAlive = false;
    ws.ping(noop);
  });
}, 10000);


const redis = require("redis");
const redisOption = {
  port:6379,
  host:'127.0.0.1'
};
const sub = redis.createClient(redisOption);
sub.on('message', function(channel, message) {
  //console.log('sub::channel=<',channel,'>');
  //console.log('sub::message=<',message,'>');
  //console.log('sub::wss=<',wss,'>');
  wss.clients.forEach(function each(client) {
    if (client.readyState === WebSocket.OPEN) {
      client.send(message);
    }
  })
});
sub.subscribe('wai.train.response');

const pub  = redis.createClient(redisOption);

