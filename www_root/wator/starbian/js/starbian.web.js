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
    if(this.prvKeyStr) {
      this.priObj = KEYUTIL.getKey(this.prvKeyStr);
      //console.log('this.priObj=<',this.priObj,'>');
      this.decryptObj = KJUR.crypto.Cipher(this.priObj);
      console.log('this.decryptObj=<',this.decryptObj,'>');
    }
    if(this.pubKeyStr) {
      this.pubObj = KEYUTIL.getKey(this.pubKeyStr);
      //console.log('this.pubObj=<',this.pubObj,'>');
    }
    this.createRemoteChannels_();
    this.createWSS_();
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
   * get remote paired public key.
   *
   * @param {String} tag 
   */
  getRemoteKey(tag) {
    var remotKeys = [];
    if(typeof tag === 'string') {
      for (var keyIn in localStorage){
        let filter = 'wator/starbian/remote/' + tag;
        if(keyIn.startsWith(filter)) {
          console.log('keyIn =<',keyIn,'>');
          console.log('filter =<',filter,'>');
          remotKeys.push(localStorage.getItem(keyIn));
        }
      }
    }
    return remotKeys;
  }
  /**
   * add remote paired public key.
   *
   * @param {String} tag 
   * @param {String} key 
   */
  addRemoteKey(tag,key) {
    if(typeof tag === 'string') {
      let keyStr = key.trim();
      let channel = KJUR.crypto.Util.sha256(keyStr);
      let keyPath = 'wator/starbian/remote/' + tag + '/' + channel;
      console.log('keyPath =<',keyPath,'>');
      localStorage.setItem(keyPath,keyStr);
    }
  }
  /**
   * publish a messege.
   *
   * @param {String} msg 
   */
  publish(channel,msg) {
    console.log('msg =<',msg,'>');
    var msgEnc = KJUR.crypto.Cipher.encrypt(msg, this.remoteChannelObj[channel]);
    var sign = this.priObj.sign(msgEnc, 'sha256');
    var pubObj = {
      enc:msgEnc,
      sign:sign,
      channel:channel
    };
    console.log('pubObj =<',pubObj,'>');
    this.ws.send(JSON.stringify(pubObj));
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
    this.createKeyPair_(function(msg){
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
  
  /**
   * decrypt public key.
   *
   * @param {String} msg 
   * @private
   */
  createRemoteChannels_() {
    this.remoteChannelObj = {};
    for (var keyIn in localStorage){
      let filter = 'wator/starbian/remote';
      if(keyIn.startsWith(filter)) {
        console.log('filter =<',filter,'>');
        console.log('keyIn =<',keyIn,'>');
        //this.remoteChannelObj
        let remoteKeyStr = localStorage.getItem(keyIn);
        console.log('remoteKeyStr =<',remoteKeyStr,'>');
        let channel = KJUR.crypto.Util.sha256(remoteKeyStr);
        this.remoteChannelObj[channel] = KEYUTIL.getKey(remoteKeyStr);
      }
    }
    console.log('this.remoteChannelObj =<',this.remoteChannelObj,'>');
  }


/*
* inner function
*/
 createKeyPair_(cb) {
  console.log(window.crypto.subtle);
  var self = this;
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
      self.pubObj = KEYUTIL.getKey(pem);

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
      self.priObj = KEYUTIL.getKey(pem);
      self.decryptObj = KJUR.crypto.Cipher(self.priObj);
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

  createWSS_() {
    this.uri = 'wss://' + location.host + '/ws/starbian';
    console.log('this.uri =<',this.uri,'>');
    this.ws = new WebSocket(this.uri);
    this.ws.onopen = this.onWSOpen_.bind(this);
    this.ws.onmessage = this.onWSMessage_.bind(this);
    this.ws.onclose = this.onWSClose_.bind(this);
    this.ws.onerror = this.onWSError_.bind(this);
  }

  onWSOpen_(event) {
    console.log('event =<',event,'>');
    var self = this;
    setTimeout(function() {
      self.ws.send('!!go go!!');
    },10);
  }
  onWSMessage_(event) {
    console.log('event =<',event,'>');
  }
  onWSError_(event) {
    console.log('event =<',event,'>');
  }
  onWSClose_(event) {
    console.log('event =<',event,'>');
  }
}






