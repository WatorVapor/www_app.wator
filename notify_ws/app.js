const WebSocket = require('ws');
const config = {host:'127.0.01', port: 8080 }
const wss = new WebSocket.Server(config);
wss.on('connection', function connection(ws) {
  ws.on('message', function incoming(message) {
    console.log('received: message=<', message,'>');
  });
});
