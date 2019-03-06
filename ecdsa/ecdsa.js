const http = require('http');
const PORT = 17263;
const HOSTNAME = '127.0.0.1';

const server = http.createServer( (req, res) => {
  res.writeHead(200, {"Content-Type": "application/json"});
  //console.log('req.url=<',req.url,'>');
  const urls = req.url.split('/');
  //console.log('urls=<',urls,'>');
  let result = {};
  if(urls.length < 5) {
    result.good = false;
  } else {
    let key = urls[1];
    let orig = urls[2];
    let signature = urls[3];
    let keyID = urls[4];
    result.good = verifyAuth(key,orig,signature,keyID);
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

function verifyAuth(pubB58,orig,sign,keyID) {
  //console.log('verifyAuth::pubB58=<',pubB58,'>');
  //console.log('verifyAuth::orig=<',orig,'>');
  //console.log('verifyAuth::sign=<',sign,'>');
  const pubKeyBuff = bs58.decode(pubB58);
  //console.log('verifyAuth::pubKeyBuff=<',pubKeyBuff,'>');
  const pubKeyHex = pubKeyBuff.toString('hex');
  //console.log('verifyAuth::pubKeyHex=<',pubKeyHex,'>');
  
  const hash1 = new rs.KJUR.crypto.MessageDigest({alg: "sha512", prov: "cryptojs"});
  hash1.updateHex(pubKeyHex);
  const hexHash1 = hash1.digest('hex');
  const hash2 = new rs.KJUR.crypto.MessageDigest({alg: "ripemd160", prov: "cryptojs"});
  hash2.updateHex(hexHash1);
  const hexHash2 = hash2.digest('hex');
  const hash2Buff = Buffer.from(hexHash2,'hex');
  const pubIDB58 = bs58.encode(hash2Buff);
  if(keyID !== pubIDB58) {
    console.log('verifyAuth::keyID=<',keyID,'>');
    console.log('verifyAuth::pubIDB58=<',pubIDB58,'>');
    return false;
  }
  
  let signEngine = new rs.KJUR.crypto.Signature({alg: 'SHA256withECDSA'});
  signEngine.init({xy: pubKeyHex, curve: 'secp256r1'});
  signEngine.updateString(orig);
  let result = signEngine.verify(sign);
  //console.log('verifyAuth result=<',result,'>');
  return result;
}
