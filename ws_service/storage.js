const WebSocket = require('ws');
const config = {host:'127.0.01', port: 19083 }
const wss = new WebSocket.Server(config);
wss.on('connection', function connection(ws) {
  ws.on('message', function (message) {
    console.log('received: message=<', message,'>');
  });
  ws.on('error', function (evt) {
    console.log('error: evt=<', evt,'>');
  });
});

var ipfsAPI = require('ipfs-api');
//var ipfs = ipfsAPI('/ip4/127.0.0.1/tcp/5001');
var ipfs = ipfsAPI('master.ipfs.wator.xyz', '5001', {protocol: 'http'});
console.log('ipfs=<',ipfs,'>');

