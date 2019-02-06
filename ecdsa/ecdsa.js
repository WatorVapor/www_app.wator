const rs = require('jsrsasign');
const http = require('http');
const PORT = 17263;
const HOSTNAME = '127.0.0.1';

const server = http.createServer( (req, res) => {
  console.log('req=<',req,'>');
  res.writeHead(200, {"Content-Type": "application/json"});
  let result = {};
  result.good = true;
  let json = JSON.stringify(result);
  res.end(json);
});

server.listen(PORT, HOSTNAME, function () {
});
