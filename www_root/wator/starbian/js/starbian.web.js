'use strict';

class StarBian {
  /**
   * Create a new `StarBian`.
   *
   */
  constructor () {
    let prvKey = localStorage.getItem('wator/starbian/keys/prv.pem');
    if(prvKey) {
      this.prvKeyStr = prvKey;
      let pubKey = localStorage.getItem('wator/starbian/keys/pub.pem');
      if(pubKey) {
        this.pubKeyStr = pubKey;
      } else {
        this.reCreatePubKey();
      }
    } else {
      this.createKeyPair();
    }
    this.priObj = KEYUTIL.getKey(this.prvKeyStr);
    this.pubObj = KEYUTIL.getKey(this.pubKeyStr);
    //console.log('this.priObj=<',this.priObj,'>');
    //console.log('this.pubObj=<',this.pubObj,'>');
    
    this.decryptObj = KJUR.crypto.Cipher(this.priObj);
    console.log('this.decryptObj=<',this.decryptObj,'>');
    }
  /**
   * get private key.
   *
   */
  getPrivate () {
    return this.prvKeyStr;
  }
  /**
   * get public key.
   *
   */
  getPublic () {
    return this.pubKeyStr;
  }
  /**
   * get authed public key.
   *
   */
  getAuthed () {
    return [''];
  }
  /**
   * publish a messege.
   *
   * @param {String} msg 
   */
  publish(msg) {
    console.log('msg =<',msg,'>');
    var msgEnc = KJUR.crypto.Cipher.encrypt(msg, this.pubObj);
    console.log('msgEnc =<',msgEnc,'>');
    var sign = this.priObj.sign(msgEnc, 'sha256');
    var pubObj = {
      enc:msgEnc,
      sign:sign
    };
    this.clientPub.publish(this.channel,JSON.stringify(pubObj));
  }
  /**
   * subscribe.
   *
   * @param {Function} callback 
   */
  subscribe(callback) {
    var self = this;
    if(this.channel) {
      this.callback.push(callback);
    } else {
      this.callback = []
      this.callback.push(callback);

      this.channel = KJUR.crypto.Util.sha256(this.pubKeyStr);
      console.log('this.channel =<',this.channel,'>');
    }
  }
  /**
   * create key pair.
   *
   * @param {Function} callback 
   * @private
   */
  createKeyPair() {
    createKeyPair_(function(msg){
      console.log('msg =<',msg,'>');
    });
  }
  /**
   * recreate public key.
   *
   * @private
   */
  reCreatePubKey() {
  }
  
  /**
   * decrypt public key.
   *
   * @param {String} msg 
   * @private
   */
  decrypt(msg) {
    //this.decryptObj
    console.log('decrypt::msg=<',msg,'>');
    var msgJson = JSON.parse(msg);
    var plainMsg = KJUR.crypto.Cipher.decrypt(msgJson.enc,this.priObj);
    console.log('decrypt::plainMsg=<',plainMsg,'>');
    return plainMsg;
  }
}


var uri = 'wss://' + location.host + '/ws/starbian';
console.log('uri =<',uri,'>');
var ws = new WebSocket(uri);
ws.onopen = onOpen;
ws.onmessage = onMessage;
ws.onclose = onClose;
ws.onerror = onError;

function onOpen(event) {
  console.log('event =<',event,'>');
  setTimeout(function() {
    ws.send('!!go go!!');
  },10);
}
function onMessage(event) {
  console.log('event =<',event,'>');
}
function onError(event) {
  console.log('event =<',event,'>');
}
function onClose(event) {
  console.log('event =<',event,'>');
}


/*
* inner function
*/
function createKeyPair_(cb) {
  console.log(window.crypto.subtle);
  window.crypto.subtle.generateKey(
  {
    name: "RSASSA-PKCS1-v1_5",
    modulusLength: 2048, //can be 1024, 2048, or 4096
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
      localStorage.setItem('wator/starbian/keys/pub.pem',pem);
      if (RSAAuth.debug) {
        console.log( typeof cb);
      }
      var token = KJUR.crypto.Util.sha512(pem);
      if (RSAAuth.debug) {
        console.log(token);
      }
      localStorage.setItem('wator/starbian/keys/channel',token);
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
      localStorage.setItem('wator/starbian/keys/prv.pem',pem);
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

