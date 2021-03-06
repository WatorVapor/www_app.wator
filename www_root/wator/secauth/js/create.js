var SecAuth = SecAuth || {};
SecAuth.debug = SecAuth.debug || true;

SecAuth.LS_AUTH_KEY_PRV = 'wator.auth.ecdsa.key.private';
SecAuth.LS_AUTH_KEY_PUB = 'wator.auth.ecdsa.key.public';
SecAuth.LS_AUTH_KEY_TOKEN = 'wator.auth.ecdsa.key.token';
SecAuth.LS_AUTH_KEY_ID = 'wator.auth.ecdsa.key.id';
SecAuth.getPubKey = function() {
  return localStorage.getItem(SecAuth.LS_AUTH_KEY_PUB);
}
SecAuth.getPriKey = function() {
  return localStorage.getItem(SecAuth.LS_AUTH_KEY_PRV);
}
SecAuth.getToken = function() {
  return localStorage.getItem(SecAuth.LS_AUTH_KEY_TOKEN);
}
SecAuth.getKeyID = function() {
  return localStorage.getItem(SecAuth.LS_AUTH_KEY_ID);
}


/*
* createKey
*/
SecAuth.createKey = function() {
  if (SecAuth.debug) {
  }
  return SecAuth.createKeyPair_();
}
/*
* 
*/
SecAuth.SS_AUTH_RUN = 'wator.auth.ecdsa.run';
SecAuth.SS_AUTH_ACCESS = 'wator.auth.ecdsa.access';
SecAuth.clearAccess = function() {
  sessionStorage.removeItem(SecAuth.SS_AUTH_RUN);
  sessionStorage.removeItem(SecAuth.SS_AUTH_ACCESS);
}

const fromHexString = hexString =>
  new Uint8Array(hexString.match(/.{1,2}/g).map(byte => parseInt(byte, 16)));

const toHexString = bytes =>
  bytes.reduce((str, byte) => str + byte.toString(16).padStart(2, '0'), '');


/*
* inner function
*/
SecAuth.createKeyPair_ = function() {
  const ecKeypair = KEYUTIL.generateKeypair("EC", "P-256");
  //console.log('SecAuth.createKeyPair_:: ecKeypair=<',ecKeypair,'>');
  let jwkPrv = KEYUTIL.getJWKFromKey(ecKeypair.prvKeyObj);
  localStorage.setItem(SecAuth.LS_AUTH_KEY_PRV,JSON.stringify(jwkPrv,undefined,2));
  //console.log('SecAuth.createKeyPair_:: jwkPrv=<',jwkPrv,'>');
  let jwkPub = KEYUTIL.getJWKFromKey(ecKeypair.pubKeyObj);
  //console.log('SecAuth.createKeyPair_:: jwkPub=<',jwkPub,'>');
  localStorage.setItem(SecAuth.LS_AUTH_KEY_PUB,JSON.stringify(jwkPub,undefined,2));
  
  const pubHex = ecKeypair.pubKeyObj.pubKeyHex;
  //console.log('SecAuth.createKeyPair_:: pubHex=<',pubHex,'>');
  const pubBuff = fromHexString(pubHex);
  console.log('SecAuth.createKeyPair_:: pubBuff=<',pubBuff,'>');
  const pubB58 = Base58.encode(pubBuff);
  console.log('SecAuth.createKeyPair_:: pubB58=<',pubB58,'>');
  //const token = KJUR.crypto.Util.sha256(pubHex);
  //console.log('SecAuth.createKeyPair_:: token=<',token,'>');
  localStorage.setItem(SecAuth.LS_AUTH_KEY_TOKEN,pubB58);
  
  const hash1 = new KJUR.crypto.MessageDigest({alg: "sha512", prov: "cryptojs"});
  hash1.updateHex(pubHex);
  const hexHash1 = hash1.digest('hex');
  const hash2 = new KJUR.crypto.MessageDigest({alg: "ripemd160", prov: "cryptojs"});
  hash2.updateHex(hexHash1);
  const hexHash2 = hash2.digest('hex');
  const hash2Buff = fromHexString(hexHash2);
  const pubIDB58 = Base58.encode(hash2Buff);
  console.log('SecAuth.createKeyPair_:: pubIDB58=<',pubIDB58,'>');
  localStorage.setItem(SecAuth.LS_AUTH_KEY_ID,pubIDB58);
  return pubB58;
}
