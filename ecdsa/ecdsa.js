const http = require('http');
const PORT = 17263;
const HOSTNAME = '127.0.0.1';

const server = http.createServer( (req, res) => {
  res.writeHead(200, {"Content-Type": "application/json"});
  console.log('req.url=<',req.url,'>');
  const urls = req.url.split('/');
  console.log('urls=<',urls,'>');
  let result = {};
  if(urls.length < 4) {
    result.good = false;
  } else {
    let key = urls[1];
    let orig = urls[2];
    let signature = urls[3];
    result.good = doSign(key,orig,signature);
  }
  let json = JSON.stringify(result);
  res.end(json);
});

server.listen(PORT, HOSTNAME, () => {
  console.log('listen PORT=<',PORT,'>');
  console.log('listen HOSTNAME=<',HOSTNAME,'>');
});

const rs = require('jsrsasign');
const bs58 = require('bs58');

function doSign(pubB58,orig,sign) {
  console.log('doSign::pubB58=<',pubB58,'>');
  console.log('doSign::orig=<',orig,'>');
  console.log('doSign::sign=<',sign,'>');
  const pubKeyBuff = bs58.decode(pubB58);
  console.log('doSign::pubKeyBuff=<',pubKeyBuff,'>');
  return false;
}
