var RSAAuth = RSAAuth || {};
RSAAuth.debug = RSAAuth.debug || true;

RSAAuth.getPubKey = function() {
  return localStorage.getItem('auth.rsa.key.public');
}
RSAAuth.getPriKey = function() {
  return localStorage.getItem('auth.rsa.key.private');
}
RSAAuth.getToken = function() {
  return localStorage.getItem('auth.rsa.token');
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
RSAAuth.clearAccess = function() {
  sessionStorage.removeItem('auth.rsa.run');
  sessionStorage.removeItem('auth.rsa.access');
}

/*
* inner function
*/
RSAAuth.createKeyPair_ = function(cb) {
  console.log(window.crypto.subtle);
  window.crypto.subtle.generateKey(
  {
    name: "RSASSA-PKCS1-v1_5",
    modulusLength: 4096, //can be 1024, 2048, or 4096
    publicExponent: new Uint8Array([0x01, 0x00, 0x01]),
    hash: {name: "SHA-256"}, //can be "SHA-1", "SHA-256", "SHA-384", or "SHA-512"
    },
    true, //whether the key is extractable (i.e. can be used in exportKey)
    ["sign", "verify"] //can be any combination of "sign" and "verify"
  )
  .then(function(key){
    //returns a keypair object
    if (RSAAuth.debug) {
      console.log(key);
      console.log(key.publicKey);
      console.log(key.privateKey);
    }
    window.crypto.subtle.exportKey(
    "jwk", //can be "jwk" (public or private), "spki" (public only), or "pkcs8" (private only)
    key.publicKey //can be a publicKey or privateKey, as long as extractable was true
    )
    .then(function(keydata){
      //returns the exported key data
      if (RSAAuth.debug) {
        console.log(keydata);
      }
      var keyObj = KEYUTIL.getKey(keydata);
      if (RSAAuth.debug) {
        console.log(keyObj);
      }
      var pem = KEYUTIL.getPEM(keyObj);
      if (RSAAuth.debug) {
        console.log(pem);
      }
      localStorage.setItem('auth.rsa.key.public',pem);
      if (RSAAuth.debug) {
        console.log( typeof cb);
      }
      var token = KJUR.crypto.Util.sha512(pem);
      if (RSAAuth.debug) {
        console.log(token);
      }
      localStorage.setItem('auth.rsa.token',token);
      if (typeof cb == 'function') {
        cb('success');
      }
    })
    .catch(function(err){
      console.error(err);
      console.trace();
    });
    window.crypto.subtle.exportKey(
    "jwk", //can be "jwk" (public or private), "spki" (public only), or "pkcs8" (private only)
    key.privateKey //can be a publicKey or privateKey, as long as extractable was true
    )
    .then(function(keydata){
        //returns the exported key data
      if (RSAAuth.debug) {
        console.log(keydata);
      }
      var keyObj = KEYUTIL.getKey(keydata);
      if (RSAAuth.debug) {
        console.log(keyObj);
      }
      var pem = KEYUTIL.getPEM(keyObj,"PKCS8PRV");
      if (RSAAuth.debug) {
        console.log(pem);
      }
      localStorage.setItem('auth.rsa.key.private',pem);
      if (typeof cb == 'function') {
        cb('success');
      }
    })
    .catch(function(err){
      console.error(err);
      console.trace();
      if (typeof cb == 'function') {
        cb('failure');
      }
    });
  })
  .catch(function(err){
    console.error(err);
    console.trace();
    if (typeof cb == 'function') {
      cb('failure');
    }
  });
}
