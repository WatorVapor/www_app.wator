var RSAAuth = RSAAuth || {};
RSAAuth.debug = RSAAuth.debug || true;

RSAAuth.LS_AUTH_KEY_PRV = 'wator.auth.ecdsa.key.private';
RSAAuth.LS_AUTH_KEY_PUB = 'wator.auth.ecdsa.key.public';
RSAAuth.LS_AUTH_KEY_TOKEN = 'wator.auth.ecdsa.key.token';
RSAAuth.getPubKey = function() {
  return localStorage.getItem(RSAAuth.LS_AUTH_KEY_PUB);
}
RSAAuth.getPriKey = function() {
  return localStorage.getItem(RSAAuth.LS_AUTH_KEY_PRV);
}
RSAAuth.getToken = function() {
  return localStorage.getItem(RSAAuth.LS_AUTH_KEY_TOKEN);
}

/*
* createKey
*/
RSAAuth.createKey = function(cb) {
  if (RSAAuth.debug) {
    console.log(cb);
  }
  RSAAuth.createKeyPair_(cb);
}
/*
* 
*/
RSAAuth.SS_AUTH_RUN = 'wator.auth.ecdsa.run';
RSAAuth.SS_AUTH_ACCESS = 'wator.auth.ecdsa.access';
RSAAuth.clearAccess = function() {
  sessionStorage.removeItem(RSAAuth.SS_AUTH_RUN);
  sessionStorage.removeItem(RSAAuth.SS_AUTH_ACCESS);
}

const fromHexString = hexString =>
  new Uint8Array(hexString.match(/.{1,2}/g).map(byte => parseInt(byte, 16)));

const toHexString = bytes =>
  bytes.reduce((str, byte) => str + byte.toString(16).padStart(2, '0'), '');


/*
* inner function
*/
RSAAuth.createKeyPair_ = function(cb) {
  const ecKeypair = KEYUTIL.generateKeypair("EC", "P-256");
  //console.log('RSAAuth.createKeyPair_:: ecKeypair=<',ecKeypair,'>');
  let jwkPrv = KEYUTIL.getJWKFromKey(ecKeypair.prvKeyObj);
  localStorage.setItem(RSAAuth.LS_AUTH_KEY_PRV,JSON.stringify(jwkPrv));
  //console.log('RSAAuth.createKeyPair_:: jwkPrv=<',jwkPrv,'>');
  let jwkPub = KEYUTIL.getJWKFromKey(ecKeypair.pubKeyObj);
  //console.log('RSAAuth.createKeyPair_:: jwkPub=<',jwkPub,'>');
  localStorage.setItem(RSAAuth.LS_AUTH_KEY_PUB,JSON.stringify(jwkPub));
  
  const pubHex = ecKeypair.pubKeyObj.pubKeyHex;
  //console.log('RSAAuth.createKeyPair_:: pubHex=<',pubHex,'>');
  const pubBuff = fromHexString(pubHex);
  console.log('RSAAuth.createKeyPair_:: pubBuff=<',pubBuff,'>');
  const pubB58 = Base58.encode(pubBuff);
  console.log('RSAAuth.createKeyPair_:: pubB58=<',pubB58,'>');
  //const token = KJUR.crypto.Util.sha256(pubHex);
  //console.log('RSAAuth.createKeyPair_:: token=<',token,'>');
  localStorage.setItem(RSAAuth.LS_AUTH_KEY_TOKEN,pubB58);
  if (typeof cb == 'function') {
    cb('success');
  }
}
