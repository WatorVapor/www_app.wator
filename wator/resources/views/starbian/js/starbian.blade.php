<script type="text/javascript">
const StarBian = {};
StarBian.LS_KEY_NAME = 'wator-starbian-ecdsa-key';
StarBian.LS_KEY_REMOTE_NAME = 'wator-starbian-ecdsa-remote-keys';
StarBian.SHARE_PUBKEY_DIFFCULTY = '0';
/**
* @return {array} key
*/
StarBian.getRemoteKey = () => {
  return StarBianCrypto.getRemoteKey();
};
/**
* @param {string} pubKey
*/
StarBian.addRemoteKey = (pubKey) => {
  StarBianCrypto.addRemoteKey(pubKey);
};
/**
* @param {string} pubKey
*/
StarBian.removeRemoteKey = (pubKey) => {
  StarBianCrypto.removeRemoteKey(pubKey);
}

/**
* override this if you what see public key of mine.
* @param {string} pubKey
*/
StarBian.onReadyOfKey = () =>{
};

document.addEventListener('DOMContentLoaded', () =>{
  setTimeout(function(){
    StarBian.Peer.InitCrypto_();
  },0);
}, false);



/**
* @classdesc This is StarBianPeer.
* @constructor
* @param {string} channelKey
*/
StarBian.Peer = class StarBianPeer {
  constructor(channelKey) {
    this.ipfsProxy = new StarBianIpfsProxy(channelKey);
    this.ipfsProxy.onReady = () => {
      if(typeof this.onReady === 'function') {
        this.onReady();
      }
    }
  }
  /**
  * @param {string} msg
  */
  publish(msg) {
    this.ipfsProxy.publish(msg);
  }
  /**
  * @param {function} cb
  */
  subscribe(cb) {
    this.ipfsProxy.subscribe(cb);
  }

  /**
  * @return {string} key
  */
  getPubKey() {
    return _insideCrypto.getPubKey();
  }
  
  // private..
  static InitCrypto_(evt) {
    if(!_insideCrypto) {
      _insideCrypto = new StarBianCrypto();
    }
  }
  
  // private..
  sendThough_(msg) {
    this.ipfsProxy.sendThough_(msg);
  }
}


/**
* @classdesc This is StarBianBroadCast.
* @constructor
* @param {string} channelKey
*/
StarBian.BroadCast = class StarBianBroadCast {
  constructor() {
    this.cast_ = new StarBian.Peer('broadcast');
    let self = this;
    this.cast_.onReady = () => {
    };
    this.cast_.subscribe( (msg) => {
      self.onBroadCast_(msg)
    });
    this.sharedKeyCache_ = {};
  }
  /**
  * @param {function} cb
  */
  broadcastPubKey(cb) {
    this.sharePubKeyCounter = 10;
    this.OneTimeCB_ = cb;
    let self = this;
    this.sharePubKeyMining_((finnish) => {
      if(finnish) {
        self.OneTimeCB_(self.sharePubKeyCounter,self.OneTimePassword_);
        self.sharePubKeyTimeOutPreStage_();
      } else {
        self.OneTimeCB_(10,'-----');
      }
    });
  }
  /**
  * @param {string} password
  * @param {function} cb
  */
  listenPubKey(password,cb) {
    this.targetPubKeyPassword_ = password;
    this.targetPubKeyCallback_ = cb;
  }
  
  
  // private
  onBroadCast_(msg) {
    console.log('StarBian.BroadCast onBroadCast_:: msg=<',msg,'>');
    if(msg.broadcast && msg.broadcast.pubkey) {
      this.onShareKey_(msg.broadcast,msg.auth,msg.assist);
    }
  }

  // private..
  sharePubKeyTimeOutPreStage_(cb) {
    this.sharePubKeyInsidePreStage_();
  }
  sharePubKeyTimeOut_(cb) {
    this.sharePubKeyInside_();
    if(typeof this.OneTimeCB_ === 'function') {
      this.OneTimeCB_(this.sharePubKeyCounter);
      this.sharePubKeyCounter--;
      if(this.sharePubKeyCounter >= 0) {
        let self = this;
        setTimeout(function() {
          self.sharePubKeyTimeOut_(cb);
        },10000);
      } else {
        this.OneTimeCB_ = false;
      }
    }
  }
  sharePubKeyTimeOutPreStage_() {	
    this.cast_.sendThough_(JSON.stringify(this.sharedKeyMsgPreStage));
  }
  sharePubKeyInside_() {
    this.cast_.sendThough_(JSON.stringify(this.sharedKeyMsg));
  }
  
  sharePubKeyMining_(cb) {	
    console.log('sharePubKeyMining_:_insideCrypto.pubKeyB58=<',_insideCrypto.pubKeyB58,'>');	
    if(!_insideCrypto.pubKeyB58) {	
      return;	
    }
    let self = this;
    let now = new Date();
    let ts = now.toISOString();
    this.OneTimePassword_ = Math.floor(Math.random()*(99999-11111)+11111);
    let shareKey = { 
      ts:ts,
      pubkey:_insideCrypto.pubKeyB58,
      password:this.OneTimePassword_
    };
    _insideCrypto.miningAuth(JSON.stringify(shareKey),(auth)=> {
      if(auth.hashSign.startsWith(StarBian.SHARE_PUBKEY_DIFFCULTY)) {
        //console.log('good lucky !!! sharePubKeyMining_:auth=<',auth,'>');
        //console.log('good lucky !!! sharePubKeyMining_:shareKey=<',shareKey,'>');
        self.sharedKeyMsgPreStage =  {	
          channel:'broadcast',	
          auth:auth,
          broadcast:shareKey	
        };	
        cb(true);
      } else {
        //console.log('bad lucky !!! sharePubKeyMining_:auth=<',auth,'>');
        //console.log('bad lucky !!! sharePubKeyMining_:shareKey=<',shareKey,'>');
        cb(false);
        self.sharePubKeyMining_(cb);
      }
    }); 
  }
  onShareKey_(shareKey,auth,assist) {
    if(!assist) {
      this.mineAssist_(shareKey,auth);
      return;
    }
    //console.log('onShareKey_ shareKey =<' , shareKey ,'>');
    let self = this;
    this.verifyAssist_(auth,assist,() => {
      //console.log('onShareKey_ self.targetPubKeyPassword_ =<' , self.targetPubKeyPassword_ ,'>');
      //console.log('onShareKey_ typeof self.targetPubKeyCallback_ =<' , typeof self.targetPubKeyCallback_,'>');
      console.log('onShareKey_ auth =<' , auth ,'>');
      console.log('onShareKey_ assist =<' , assist ,'>');
      //self.sharedKeyCache_;
      if(self.targetPubKeyPassword_ === shareKey.password.toString()) {
        if(typeof this.targetPubKeyCallback_ === 'function') {
          self.targetPubKeyCallback_(shareKey.pubkey);
          self.sharePubKeyCounter = 0;
        }
      }
    });
  }
  
  mineAssist_(shareKey,auth) {
    let self = this;
    _insideCrypto.signAssist(auth,(assisted) => {
      //console.log('mineAssist_ assisted =<' , assisted ,'>');
      if(assisted.hashSign.startsWith(StarBian.SHARE_PUBKEY_DIFFCULTY)) {
        //console.log('good lucky !!! onShareKey_:assisted=<',assisted,'>');
        self.sharedKeyMsg =  {	
          channel:'broadcast',	
          auth:auth,
          assist:assisted,
          broadcast:shareKey	
        };
        self.sharePubKeyTimeOut_();
      } else {
        //console.log('bad lucky !!! onShareKey_:assisted=<',assisted,'>');
        self.onShareKey_(shareKey,auth);
      }
   })
  }

  verifyAssist_(auth,assist,cb) {
    console.log('verifyAssist_ auth =<' , auth ,'>');
    console.log('verifyAssist_ assist =<' , assist ,'>');
    if(!auth.hashSign.startsWith(StarBian.SHARE_PUBKEY_DIFFCULTY)) {
      console.log('verifyAssist_ !!! bad hash auth =<' , auth ,'>');
      return;
    }
    if(!assist.hashSign.startsWith(StarBian.SHARE_PUBKEY_DIFFCULTY)) {
      console.log('verifyAssist_ !!! bad hash assist =<' , assist ,'>');
      return;
    }
    if(auth.hash !== assist.orig.orig ) {
      console.log('verifyAssist_ !!! bad hash auth.hash =<' , auth.hash ,'>');
      console.log('verifyAssist_ !!! bad hash assist.orig.orig =<' , assist.orig.orig ,'>');
      return;
    }
    let self = this;
    _insideCrypto.verifyAssist(assist,(result) => {
      console.log('verifyAssist_ result =<' , result ,'>');
      cb();
    });
  }

}


// private class
class StarBianCrypto {
  constructor() {
    this.onReadyKey = StarBian.onReadyOfKey;
    //console.log('StarBianCrypto');	
    let key = localStorage.getItem(StarBian.LS_KEY_NAME);
    //console.log('StarBianCrypto:key=<',key,'>');
    if(key) {
      this.onLoadSavedKey(key);
    } else {
      this.onCreateKey();
    }  
    let keyRemote = localStorage.getItem(StarBian.LS_KEY_REMOTE_NAME);
    if(!keyRemote) {
      let keyStr = JSON.stringify([]);
      //console.log('StarBianCrypto keyStr=<' , keyStr , '>');
      localStorage.setItem(StarBian.LS_KEY_REMOTE_NAME,keyStr);
    }
    this.createECDHKey();  
  }

  /**
  * @return {string} key
  */
  getPubKey() {
    return this.pubKeyB58;
  }
  
  /**
  * @return {array} key
  */
  static getRemoteKey() {
    let key = localStorage.getItem(StarBian.LS_KEY_REMOTE_NAME);
    let keyJson = JSON.parse(key);
    if(keyJson) {
      return keyJson;
    } else {
      return [];
    }
  }
  /**
  * @param {string} pubKey
  */
  static addRemoteKey(pubKey) {
    //console.log('StarBian.addRemoteKey pubKey=<' , pubKey , '>');
    let key = localStorage.getItem(StarBian.LS_KEY_REMOTE_NAME);
    let keyJson = JSON.parse(key);
    if(keyJson) {
      keyJson.push(pubKey);
      keyJson = keyJson.filter( (value, index, self) => { 
        return self.indexOf(value) === index;
      });
    } else {
      keyJson = [pubKey];
    }
    let keyStr = JSON.stringify(keyJson);
    //console.log('StarBian addRemoteKey keyStr=<' , keyStr , '>');
    localStorage.setItem(StarBian.LS_KEY_REMOTE_NAME,keyStr);
  }
  /**
  * @param {string} pubKey
  */
  static removeRemoteKey(pubKey) {
    //console.log('StarBian.removeKey pubKey=<' , pubKey , '>');
    let key = localStorage.getItem(StarBian.LS_KEY_REMOTE_NAME);
    let keyJson = JSON.parse(key);
    //console.log('StarBian.removeKey keyJson=<' , keyJson , '>');
    let newKeys = keyJson.filter(key => pubKey !== key);
    //console.log('StarBian.removeKey newKeys=<' , newKeys , '>');
    let keyStr = JSON.stringify(newKeys);
    //console.log('StarBian.removeKey keyStr=<' , keyStr , '>');
    localStorage.setItem(StarBian.LS_KEY_REMOTE_NAME,keyStr);
  }

  onCreateKey () {
    let self = this;
    window.crypto.subtle.generateKey(
      {
        name: 'ECDSA',
        namedCurve: 'P-256',
      },
      true,
      ['sign','verify']
    )
    .then(function(key){
      self.pubKey = key.publicKey;
      self.notifyPubKey(key.publicKey);
      self.prvKey = key.privateKey;
      self.savePrivKey(key.privateKey);
    })
    .catch(function(err){
      console.error(err);
    });
  }

  savePrivKey(key) {
    window.crypto.subtle.exportKey('jwk',key)
    .then(function(keydata){
      //console.log('savePrivKey keydata=<' , keydata , '>');
      let keyStr = JSON.stringify(keydata);
      //console.log('savePrivKey keyStr=<' , keyStr , '>');
      localStorage.setItem(StarBian.LS_KEY_NAME,keyStr);
    })
    .catch(function(err){
      console.error(err);
    });
  }

  notifyPubKey(key) {
    let self = this;
    window.crypto.subtle.exportKey('raw',key)
    .then(function(keydata){
      //console.log('getPubKey keydata=<' , keydata , '>');
      self.pubKeyB58 = Base58.encode(new Uint8Array(keydata));
      //console.log('getPubKey self.pubKeyB58=<' , self.pubKeyB58 , '>');
      if(typeof self.onReadyKey === 'function') {
        self.onReadyKey(self.pubKeyB58);
      }
    })
    .catch(function(err){
      console.error(err);
    });
  }

  createECDHKey () {
    let self = this;
    window.crypto.subtle.generateKey(
      {
        name: 'ECDH',
        namedCurve: 'P-256',
      },
      false,
      ['deriveKey','deriveBits']
    )
    .then(function(key){
      self.ECDHKey = key;
      self.exportECDHPubKey(key.publicKey);
    })
    .catch(function(err){
      console.error(err);
    });
  }
  exportECDHPubKey(pubKey) {
    let self = this;
    crypto.subtle.exportKey('jwk', pubKey)
    .then(function(keydata){
      //console.log('exportECDHPubKey keydata=<' , keydata , '>');
      self.ECDHKeyPubJwk = keydata;
    })
    .catch(function(err){
      console.error(err);
    });
  }

  onLoadSavedKey(privSave) {
    let key = JSON.parse(privSave);
    if(!key) {
      return;
    }
    let self = this;
    window.crypto.subtle.importKey(
      'jwk',
      key,
      {
        name: 'ECDSA',
        namedCurve: 'P-256', 
      },
      true, 
      ['sign']
    )
    .then(function(privateKey){
      //console.log('privateKey=<' , privateKey , '>');
      self.prvKey = privateKey;
    })
    .catch(function(err){
      console.error(err);
    });
    self.rsPrvKey = KEYUTIL.getKey(key);
    //console.log('self.rsPrvKey=<',self.rsPrvKey ,'>');
    //console.log('key=<',key ,'>');
    //let key
    delete key.d;
    key.key_ops[0] = 'verify';
    //console.log('key=<',key ,'>');
    window.crypto.subtle.importKey(
      'jwk',
      key,
      {
        name: 'ECDSA',
        namedCurve: 'P-256', 
      },
      true, 
      ['verify']
    )
    .then(function(publicKey){
      //console.log('publicKey=<' , publicKey , '>');
      self.pubKey = publicKey;
      self.notifyPubKey(publicKey);
    })
    .catch(function(err){
      console.error(err);
    });
    this.rsPubKey = KEYUTIL.getKey(key);
    //console.log('this.rsPubKey=<',this.rsPubKey ,'>');
    this.pubKeyJWK = JSON.parse(JSON.stringify(key));
  }

  signAuth(msg,cb) {
    //console.log('signAuth msg=<' , msg , '>');
    let self= this;
    crypto.subtle.digest("SHA-256", new TextEncoder("utf-8").encode(msg))
    .then(function(buf) {
      let hash = base64js.fromByteArray(new Uint8Array(buf));
      //console.log('signAuth hash=<' , hash , '>');
      let ecSign = new KJUR.crypto.ECDSA({'curve': 'secp256r1'});
      //console.log('signAuth ecSign=<' , ecSign , '>');
      //console.log('signAuth self.prvKeyHex=<' , self.prvKeyHex , '>');

      let signEngine = new KJUR.crypto.Signature({alg: 'SHA256withECDSA'});
      signEngine.init({d: self.rsPrvKey.prvKeyHex, curve: 'secp256r1'});
      signEngine.updateString(hash);
      let signatureHex = signEngine.sign();
      //console.log('signAuth signatureHex=<' , signatureHex , '>');
      let signature = {
        pubKeyB58:self.pubKeyB58,
        hash:hash,
        sign:signatureHex
      };
      cb(signature);
    })
    .catch(function(err){
      console.error(err);
    });
  }


  miningAuth(msg,cb) {
    //console.log('signAuth msg=<' , msg , '>');
    let self = this;
    crypto.subtle.digest("SHA-256", new TextEncoder("utf-8").encode(msg))
    .then(function(buf) {
      let hash = base64js.fromByteArray(new Uint8Array(buf));
      //console.log('signAuth hash=<' , hash , '>');
      let ecSign = new KJUR.crypto.ECDSA({'curve': 'secp256r1'});
      //console.log('signAuth ecSign=<' , ecSign , '>');
      //console.log('signAuth self.prvKeyHex=<' , self.prvKeyHex , '>');

      let signEngine = new KJUR.crypto.Signature({alg: 'SHA256withECDSA'});
      signEngine.init({d: self.rsPrvKey.prvKeyHex, curve: 'secp256r1'});
      signEngine.updateString(hash);
      let signatureHex = signEngine.sign();
      //console.log('signAuth signatureHex=<' , signatureHex , '>');
      let hashSign = KJUR.crypto.Util.sha256(signatureHex);
      let signature = {
        pubKeyB58:self.pubKeyB58,
        hash:hash,
        sign:signatureHex,
        hashSign:hashSign
      };
      cb(signature);
    })
    .catch(function(err){
      console.error(err);
    });
  }

  signAssist(auth,cb) {
    console.log('signAssist auth=<' , auth , '>');
    let now = new Date();
    let ts = now.toISOString();
    let msgJson = {orig:auth.hash,ts:ts};
    let msg = JSON.stringify(msgJson);
    let self = this;
    crypto.subtle.digest("SHA-256", new TextEncoder("utf-8").encode(msg))
    .then(function(buf) {
      let hash = base64js.fromByteArray(new Uint8Array(buf));
      //console.log('signAssist hash=<' , hash , '>');
      let ecSign = new KJUR.crypto.ECDSA({'curve': 'secp256r1'});
      //console.log('signAssist ecSign=<' , ecSign , '>');
      //console.log('signAssist self.prvKeyHex=<' , self.prvKeyHex , '>');

      let signEngine = new KJUR.crypto.Signature({alg: 'SHA256withECDSA'});
      signEngine.init({d: self.rsPrvKey.prvKeyHex, curve: 'secp256r1'});
      signEngine.updateString(hash);
      let signatureHex = signEngine.sign();
      //console.log('signAssist signatureHex=<' , signatureHex , '>');
      let hashSign = KJUR.crypto.Util.sha256(signatureHex);
      let signature = {
        pubKeyB58:self.pubKeyB58,
        hash:hash,
        orig:msgJson,
        sign:signatureHex,
        hashSign:hashSign
      };
      cb(signature);
    })
    .catch(function(err){
      console.error(err);
    });
  }

  verifyAuth(content,auth,channel,cb) {
    //console.log('verifyAuth JSON.stringify(content)=<' , JSON.stringify(content) ,'>');
    let self = this;
    crypto.subtle.digest("SHA-256", new TextEncoder("utf-8").encode(JSON.stringify(content)))
    .then(function(buf){
      let hashCal = base64js.fromByteArray(new Uint8Array(buf));
      if(hashCal !== auth.hash) {
        console.log('verifyAuth  not authed !!! hashCal=<' , hashCal , '>');
        console.log('verifyAuth  not authed !!! auth.hash=<' , auth.hash , '>');
        console.log('verifyAuth: not authed !!! content=<',content,'>');
        console.log('verifyAuth: not auth !!!  auth=<',auth,'>');
      } else {
        self.Bs58Key2RsKey(auth.pubKeyB58,(pubKey) => {
          //console.log('verifyAuth pubKey=<' , pubKey , '>');
          let signEngine = new KJUR.crypto.Signature({alg: 'SHA256withECDSA'});
          signEngine.init({xy: pubKey.pubKeyHex, curve: 'secp256r1'});
          signEngine.updateString(auth.hash);
          let result = signEngine.verify(auth.sign);
          if(result) {
            cb(result);
          } else {
            console.log('verifyAuth not authed !!! result=<' , result , '>');
            console.log('verifyAuth not authed !!! auth=<' , auth , '>');
          }
        });
      }
    })
    .catch(function(err){
      console.error(err);
    });
  }
  
  
  verifyAssist(assist,cb) {
    //console.log('verifyAssist assist=<' , assist ,'>');
    let self = this;
    crypto.subtle.digest("SHA-256", new TextEncoder("utf-8").encode(JSON.stringify(assist.orig)))
    .then(function(buf){
      let hashCal = base64js.fromByteArray(new Uint8Array(buf));
      if(hashCal !== assist.hash) {
        console.log('verifyAssist  not authed !!! hashCal=<' , hashCal , '>');
        console.log('verifyAssist  not authed !!! assist.hash=<' , assist.hash , '>');
        console.log('verifyAssist: not authed !!! assist.orig=<',assist.orig,'>');
      } else {
        self.Bs58Key2RsKey(assist.pubKeyB58,(pubKey) => {
          //console.log('verifyAssist pubKey=<' , pubKey , '>');
          let signEngine = new KJUR.crypto.Signature({alg: 'SHA256withECDSA'});
          signEngine.init({xy: pubKey.pubKeyHex, curve: 'secp256r1'});
          signEngine.updateString(assist.hash);
          let result = signEngine.verify(assist.sign);
          if(result) {
            cb(result);
          } else {
            console.log('verifyAssist not authed !!! result=<' , result , '>');
            console.log('verifyAssist not authed !!! assist=<' , assist , '>');
          }
        });
      }
    })
    .catch(function(err){
      console.error(err);
    });
  }


  Bs58Key2RsKey(bs58Key,cb) {
    //console.log('Bs58Key2RsKey bs58Key=<',bs58Key,'>');
    const pubKeyBuff = Base58.decode(bs58Key);
    //console.log('Bs58Key2RsKey pubKeyBuff=<',pubKeyBuff,'>');  
    crypto.subtle.importKey(
      'raw',
      pubKeyBuff,
      {
        name: 'ECDSA',
        namedCurve: 'P-256', 
      },
      true, 
      ['verify']
    )
    .then(function(pubKey){
      //console.log('Bs58Key2RsKey:pubKey=<' , pubKey , '>');
      crypto.subtle.exportKey('jwk', pubKey)
      .then(function(keydata){
        //console.log('Bs58Key2RsKey keydata=<' , keydata , '>');
        let rsKey = KEYUTIL.getKey(keydata);	
        //console.log('Bs58Key2RsKey rsKey=<',rsKey,'>');
        cb(rsKey);
      })
      .catch(function(err){
        console.error(err);
      });
    })
    .catch(function(err){
      console.error(err);
    });
  }

  exchangeKey (pubKey,cb) {
    console.log('exchangeKey pubKey=<' , pubKey , '>');
    let self = this;
    crypto.subtle.importKey(
      'jwk',
      pubKey,
      { name: 'ECDH', namedCurve: 'P-256'},
      false,
      []
    ).then(key => {
      self.onExchangeKey(key,cb);
    })
    .catch(function(err){
      console.error(err);
    });
  };

  onExchangeKey(remotePubKey,cb) {
    console.log('onExchangeKey remotePubKey=<' , remotePubKey , '>');
    let self = this;
    crypto.subtle.deriveKey( 
      { name: 'ECDH', namedCurve: 'P-256', public: remotePubKey },
      self.ECDHKey.privateKey,
      { name: 'AES-GCM', length: 128 },
      false,
      ['encrypt', 'decrypt']
    ).then(keyAES => {
      console.log('onExchangeKey keyAES=<' , keyAES , '>');
      self.AESKey = keyAES;
      cb(keyAES);
    })
    .catch(function(err){
      console.error(err);
    });
  }

  encrypt (msg,cb) {
    if(!this.AESKey) {
      console.log('encrypt this.AESKey=<' , this.AESKey , '>');
      console.log('encrypt msg=<' , msg , '>');
      return;
    }
    //console.log('encrypt msg=<' , msg , '>');
    let self = this;
    let iv = window.crypto.getRandomValues(new Uint8Array(12));
    const alg = { 
      name: 'AES-GCM',
      iv: iv
    };
    const ptUint8 = new TextEncoder().encode(JSON.stringify(msg));
    crypto.subtle.encrypt( 
      alg,
      self.AESKey,
      ptUint8
    ).then(enMsg => {
      console.log('encrypt enMsg=<' , enMsg , '>');
      let enObj = {
        iv:base64js.fromByteArray(iv),
        encrypt:base64js.fromByteArray(new Uint8Array(enMsg))
      };
      console.log('encrypt enObj=<' , enObj , '>');
      cb(enObj);
    })
    .catch(function(err){
      console.error(err);
    });
  }
  decrypt (msg,cb) {
    if(!this.AESKey) {
      console.log('decrypt this.AESKey=<' , this.AESKey , '>');
      console.log('decrypt msg=<' , msg , '>');
      return;
    }
    const alg = { 
      name: 'AES-GCM',
      iv: base64js.toByteArray(msg.iv)
    };
    const ptUint8 = base64js.toByteArray(msg.encrypt);
    crypto.subtle.decrypt( 
      alg,
      this.AESKey,
      ptUint8
    ).then(plainBuff => {
      console.log('decrypt plainBuff=<' , plainBuff , '>');
      let plainText = new TextDecoder().decode(plainBuff);
      console.log('decrypt plainText=<' , plainText , '>');
      let plainJson = JSON.parse(plainText);
      console.log('WATOR.decrypt plainJson=<' , plainJson , '>');
      cb(plainJson);
    })
    .catch(function(err){
      console.error(err);
    });
  }

}
let _insideCrypto = false; 

class StarBianIpfsProxy {
  constructor(channelKey) {
    let uri = "wss://www.wator.xyz/starbian/ipfs/wss";
    this.ws_ = new WebSocket(uri);
    this.channelKey_ = channelKey;
    let self = this;
    
    this.ws_.onopen =  (evt) => {
      self.onNotifyOpen_(evt);
    };
    this.ws_.onmessage = (evt) => {
      self.onNotifyMessage_(evt);
    };
    this.ws_.onclose = (evt) => {
      self.onNotifyClose_(evt);
    };
    this.ws_.onerror = (evt) => { 
      self.onNotifyError_(evt);
    };
  }


  publish(msg) {
    let self = this;
    _insideCrypto.encrypt(JSON.stringify(msg),function(encrypt) {
      //console.log('publish:encrypt=<',encrypt,'>');	
      _insideCrypto.signAuth(JSON.stringify(encrypt),function(auth) {
        let sentMsg = {
          channel:self.channelKey_,
          auth:auth,
          encrypt:encrypt
        };
        if(self.ws_.readyState) {
          self.ws_.send(JSON.stringify(sentMsg));
        }
      });
    });
  }
  
  subscribe(cb) {
    this.subscribe_ = cb;
  }	
  
    
  onNotifyOpen_(evt) {
    console.log('onNotifyOpen_:evt=<',evt,'>');
    let self = this;
    setTimeout(function(){
      self.subscribeChannel_();
    },1000+10);
    setTimeout(function() {
      self.tryExchangeKey_('request');
    },1000+30);
  }
  
  onNotifyMessage_(evt) {
    //console.log('onNotifyMessage_:evt.data=<',evt.data,'>');
    let jsonMsg = JSON.parse(evt.data);
    console.log('onNotifyMessage_:jsonMsg=<',jsonMsg,'>');
    if(jsonMsg && jsonMsg.msg ) {
      if(this.channelKey_ === 'broadcast' && jsonMsg.channel === 'broadcast') {
        this.onWssMessage_(jsonMsg.msg,jsonMsg.channel);
      } else if(jsonMsg.msg.auth && jsonMsg.msg.auth.pubKeyB58 === this.channelKey_) {
        this.onWssMessage_(jsonMsg.msg,jsonMsg.channel);
      } else {
        console.warn('onNotifyMessage_:!!! data out of my eye evt.data=<',evt.data,'>');
      }
    } else {
      console.warn('onNotifyMessage_: !!! bad format evt.data=<',evt.data,'>');
    }
  }
  onNotifyClose_(evt) {
    console.log('onNotifyClose_:evt=<',evt,'>');
  }
  onNotifyError_(evt) {
    console.log('onNotifyError_:evt=<',evt,'>');
  }  

  onWssMessage_(msg,channel) {
    console.log('onWssMessage_:msg=<',msg,'>');
    if(msg.auth) {
      let content = msg.encrypt || msg.ecdh || msg.subscribe || msg.broadcast;
      let self = this;
      _insideCrypto.verifyAuth(content,msg.auth,channel,() => {
        if(msg.encrypt) {
          self.onEncrypt_(msg.encrypt,channel);
        } else if(msg.ecdh) {
          self.onGoodECDH_(msg.ecdh);
        } else if(msg.broadcast) {
          self.onBroadCast_(msg);
        } else {
          console.log('onWssMessage_ not supported  :msg=<',msg,'>');
        }
      });
    }
  }
  onBroadCast_(msg) {
    console.log('onBroadCast_:msg=<',msg,'>');
    if(typeof this.subscribe_ === 'function') {
      this.subscribe_(msg);
    }
  }

  onGoodMessage_(msg,channel) {
    //console.log('onGoodMessage_:msg=<',msg,'>');
    if(typeof this.subscribe_ === 'function') {
      this.subscribe_(msg,channel);
    }
  }
  onGoodECDH_(ecdh) {
    //console.log('onGoodECDH_:ecdh=<',ecdh,'>');
    if(ecdh.type === 'request') {
      this.tryExchangeKey_('response');
    }
    this.exchangeKeyDone_ = true;
    let self = this;
    _insideCrypto.exchangeKey(ecdh.key,function(keyAes) {
      //console.log('onGoodECDH_:keyAes=<',keyAes,'>');
      setTimeout(function() {
        if(typeof self.onReady === 'function') {
          self.onReady();
        }
      },0);
    });
  }
  onEncrypt_(encrypt,channel) {
    //console.log('onEncrypt_:encrypt=<',encrypt,'>');
    let self = this;
    _insideCrypto.decrypt(encrypt,function(plainMsg) {
      //console.log('onEncrypt_:typeof plainMsg=<',typeof plainMsg,'>');
      if(plainMsg) {
        if(typeof plainMsg === 'string') {
          self.onGoodMessage_(JSON.parse(plainMsg),channel);
        } else {
          self.onGoodMessage_(plainMsg,channel);
        }
      } else {
        console.log('onEncrypt_:plainMsg=<',plainMsg,'>');
      }
    });
  }

  subscribeChannel_() {	
    console.log('subscribeChannel_:_insideCrypto.pubKeyB58=<',_insideCrypto.pubKeyB58,'>');	
    if(!_insideCrypto.pubKeyB58) {	
      return;	
    } 	
    let subs = { ts:new Date()};
    let self = this;
    _insideCrypto.signAuth(JSON.stringify(subs),function(auth) {	
      let sentMsg = {	
        channel:_insideCrypto.pubKeyB58,	
        auth:auth,	
        subscribe:subs	
      };	
      //console.log('subscribeChannel_:self.ws_=<',self.ws_,'>');	
      if(self.ws_.readyState) {	
        self.ws_.send(JSON.stringify(sentMsg));	
      }	
    });	
  }

  tryExchangeKey_(type) {
    if(!this.channelKey_ || this.channelKey_ === 'broadcast') {
      console.log('tryExchangeKey: can not do it !!! this.channelKey_=<',this.channelKey_,'>');
      return;
    }
    let ecdh = {
      key:_insideCrypto.ECDHKeyPubJwk,
      type:type,
      ts:new Date()
    };
    let self = this;
    _insideCrypto.signAuth(JSON.stringify(ecdh),function(auth) {
      let sentMsg = {
        channel:self.channelKey_,
        auth:auth,
        ecdh:ecdh
      };
      //console.log('tryExchangeKey:self.ws_=<',self.ws_,'>');
      if(self.ws_.readyState) {
        self.ws_.send(JSON.stringify(sentMsg));
      }
    });
  }

  // private..
  sendThough_(msg) {
    if(this.ws_.readyState) {
      this.ws_.send(msg);
    }
  }


};

</script>
