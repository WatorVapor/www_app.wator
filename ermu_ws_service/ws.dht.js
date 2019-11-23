const WebSocket = require('ws');
const config = {host:'127.0.0.1', port: 20081 }
const wss = new WebSocket.Server(config);
const channelWS2DHT = 'enum.www.search.ws2dht';
const channelDHT2WS = 'enum.www.search.dht2ws';

wss.on('connection', (ws) => {
  onConnected(ws);
});

const onConnected = (ws) => {
  ws.on('message', (message) => {
    onWSmsg(message);
  });
  ws.on('error', (evt) => {
    console.log('error: evt=<', evt,'>');
  });
  ws.isAlive = true;
  ws.on('pong', heartBeatWS);  
}
const onWSmsg = (message) => {
  console.log('onWSmsg: message=<', message,'>');
  pubRedis.publish(channelWS2DHT,message);
};

const redis = require("redis");
const redisOption = {
  port:6379,
  host:'127.0.0.1'
};
const subRedis = redis.createClient(redisOption);
const pubRedis  = redis.createClient(redisOption);
subRedis.on('message', (channel, message) => {
  onRedisMsg(channel, message);
});
subRedis.subscribe(channelDHT2WS);

const onRedisMsg = () => {
  //console.log('onRedisMsg::channel=<',channel,'>');
  //console.log('onRedisMsg::message=<',message,'>');
  //console.log('onRedisMsg::wss=<',wss,'>');
  wss.clients.forEach( (client) => {
    if (client.readyState === WebSocket.OPEN) {
      client.send(message);
    }
  });
}


const noop = () => {};
const heartBeatWS = () => {
  this.isAlive = true;
}
const doPingWS = () => {
  wss.clients.forEach((ws) => {
    if (ws.isAlive === false) {
      return ws.terminate();
    }
    ws.isAlive = false;
    ws.ping(noop);
  });  
};
const interval = setInterval(doPingWS, 10000);



