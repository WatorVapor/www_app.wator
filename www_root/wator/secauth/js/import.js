var RSAAuth = RSAAuth || {};
RSAAuth.debug = RSAAuth.debug || false;

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
* importKey
*/
RSAAuth.importKey = function(keys,cb) {
  if (RSAAuth.debug) {
    console.log(cb);
  }
  RSAAuth.importeKeyPair_(keys,cb);
}
RSAAuth.clearAccess = function() {
  sessionStorage.removeItem('auth.rsa.run');
  sessionStorage.removeItem('auth.rsa.access');
}

function extracPrivate_(keys) {
  var start = keys.indexOf('-----BEGIN PRIVATE KEY-----');
  var end = keys.indexOf('-----END PRIVATE KEY-----') + '-----END PRIVATE KEY-----'.length;
//  console.log(start,end);
  return keys.substring(start,end);
}
function extracPublic_(keys) {
  var start = keys.indexOf('-----BEGIN PUBLIC KEY-----');
  var end = keys.indexOf('-----END PUBLIC KEY-----') + '-----END PUBLIC KEY-----'.length;
//  console.log(start,end);
  return keys.substring(start,end);
}

/*
* inner function
*/
RSAAuth.importeKeyPair_ = function(keys,cb) {
  var priKey = extracPrivate_(keys);
  var rsaPriKey = KEYUTIL.getKey(priKey);
  if(RSAAuth.debug) {
    console.log(priKey);
    console.log(rsaPriKey);
  }
  var orig = 'wator.vapor';
  var sign = rsaPriKey.signString(orig, 'sha512')
  if(RSAAuth.debug) {
    console.log(sign);
  }
  var pubKey = extracPublic_(keys);
  var rsaPubKey = KEYUTIL.getKey(pubKey);
  if(RSAAuth.debug) {
    console.log(pubKey);
    console.log(rsaPubKey);
  }
  var valid = rsaPubKey.verifyString(orig,sign);
  if(RSAAuth.debug) {
    console.log(valid);
  }
  if(valid) {
    localStorage.setItem('auth.rsa.key.private',priKey);
    localStorage.setItem('auth.rsa.key.public',pubKey);
    RSAAuth.upPubKey();
    if (typeof cb == 'function') {
      cb('success');
    } 
  } else {
    cb('failure');
  }
}
