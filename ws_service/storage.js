const WebSocket = require('ws');
const config = {host:'127.0.01', port: 19083 }
const wss = new WebSocket.Server(config);
wss.on('connection', function connection(ws) {
  ws.on('message', function (msg) {
    try {
      let jsonMsg = JSON.parse(msg);
      console.log('message: jsonMsg=<', jsonMsg,'>');
      let files = [];
      jsonMsg.forEach(function(val, i) {
        console.log('message: val=<', val,'>');
        let file = {};
        file.path = val.path;
        file.content = Buffer.from(val.content, 'base64');
        files.push(file);
      });
      console.log('message: files=<', files,'>');
      addFiles2IpfsStorage(files);
    } catch(e) {
      console.log('message: e=<', e,'>');
      console.log('message: msg=<', msg,'>');
    }
  });
  ws.on('error', function (evt) {
    console.log('error: evt=<', evt,'>');
  });
});

/*
function base64ToBuffer(base64) {
  let binstr = atob(base64);
  let buf = new Uint8Array(binstr.length);
  Array.prototype.forEach.call(binstr, function (ch, i) {
    buf[i] = ch.charCodeAt(0);
  });
  return buf;
}
*/


var ipfsAPI = require('ipfs-api');
//var ipfs = ipfsAPI('/ip4/127.0.0.1/tcp/5001');
var ipfs = ipfsAPI('www.wator.xyz', '5001', {protocol: 'https'});
console.log('ipfs=<',ipfs,'>');

ipfs.id(function (err, identity) {
  if (err) {
    throw err;
  }
  console.log('identity=<',identity,'>');
});


function addFiles2IpfsStorage(files) {
  ipfs.files.add(files,function(err, result){
    if (err) {
      throw err;
    }
    console.log('uploadSliceToIpfs::result=<',result,'>');
    setTimeout(function () { 
      uploadIPFSInfo(result);
    },1);
  });
}
