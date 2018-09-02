<script type="text/javascript">
'use strict'

$(document).ready(function(){
  setTimeout(function(){
    StarBian.InitCrypto_();
  },0);
});

const LS_KEY_NAME = 'wator-starbian-ecdsa-key';
const LS_KEY_REMOTE_NAME = 'wator-starbian-ecdsa-remote-keys';


/**
* @classdesc This is StarBian.
* @constructor
* @param {string} channelKey
*/
class StarBian {
  constructor(channelKey) {
    this.ipfsProxy = new StarBianIpfsProxy(channelKey);
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
  * @param {function} cb
  */
  sharePubKey(cb) {
    this.ipfsProxy.sharePubKey(cb);
  }
  /**
  * @param {string} password
  * @param {function} cb
  */
  searchPubKey(password,cb) {
    this.ipfsProxy.searchPubKey(password,cb);
  }

  /**
  * @return {string} key
  */
  static getPubKey() {
  }
  /**
  * @return {array} key
  */
  static getRemoteKey() {
    let key = localStorage.getItem(LS_KEY_REMOTE_NAME);
    let keyJson = JSON.parse(key);
    if(keyJson) {
      return keyJson;
    } else {
      return [];
    }
  }
  /**
  * @param {string} key
  */
  static addRemoteKey(key) {
    console.log('StarBian.addRemoteKey pubKey=<' , pubKey , '>');
    let key = localStorage.getItem(LS_KEY_REMOTE_NAME);
    let keyJson = JSON.parse(key);
    if(keyJson) {
      keyJson.push(pubKey);
      keyJson = keyJson.filter( onlyUnique );
    } else {
      keyJson = [pubKey];
    }
    let keyStr = JSON.stringify(keyJson);
    console.log('StarBian addRemoteKey keyStr=<' , keyStr , '>');
    localStorage.setItem(LS_KEY_REMOTE_NAME,keyStr);
  }
  /**
  * @param {string} key
  */
  static removeRemoteKey(key) {
    console.log('StarBian.removeKey pubKey=<' , pubKey , '>');
    let key = localStorage.getItem(LS_KEY_REMOTE_NAME);
    let keyJson = JSON.parse(key);
    console.log('StarBian.removeKey keyJson=<' , keyJson , '>');
    let newKeys = keyJson.filter(key => pubKey !== key);
    console.log('StarBian.removeKey newKeys=<' , newKeys , '>');
    let keyStr = JSON.stringify(newKeys);
    console.log('StarBian.removeKey keyStr=<' , keyStr , '>');
    localStorage.setItem(LS_KEY_REMOTE_NAME,keyStr);
  }
  
  
  // private..
  static InitCrypto_(evt) {
    if(!_insideCrypto) {
      _insideCrypto = new StarBianCrypto();
    }
  }
}

// private class
class StarBianCrypto {
  constructor() {
    this.onReadyKey = StarBian.onReadyOfKey;
    //console.log('StarBianCrypto');	
    let key = localStorage.getItem(LS_KEY_NAME);
    //console.log('StarBianCrypto:key=<',key,'>');
    if(key) {
      this.onLoadSavedKey(key);
    } else {
      this.onCreateKey();
    }  
    let keyRemote = localStorage.getItem(LS_KEY_REMOTE_NAME);
    if(!keyRemote) {
      let keyStr = JSON.stringify([]);
      //console.log('StarBianCrypto keyStr=<' , keyStr , '>');
      localStorage.setItem(LS_KEY_REMOTE_NAME,keyStr);
    }
    this.createECDHKey();  
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
      console.log('savePrivKey keydata=<' , keydata , '>');
      let keyStr = JSON.stringify(keydata);
      console.log('savePrivKey keyStr=<' , keyStr , '>');
      localStorage.setItem(LS_KEY_NAME,keyStr);
    })
    .catch(function(err){
      console.error(err);
    });
  }

  notifyPubKey(key) {
    let self = this;
    window.crypto.subtle.exportKey('raw',key)
    .then(function(keydata){
      console.log('getPubKey keydata=<' , keydata , '>');
      self.pubKeyB58 = Base58.encode(new Uint8Array(keydata));
      console.log('getPubKey self.pubKeyB58=<' , self.pubKeyB58 , '>');
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
      console.log('exportECDHPubKey keydata=<' , keydata , '>');
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
      console.log('privateKey=<' , privateKey , '>');
      self.prvKey = privateKey;
    })
    .catch(function(err){
      console.error(err);
    });
    self.rsPrvKey = KEYUTIL.getKey(key);
    console.log('self.rsPrvKey=<',self.rsPrvKey ,'>');
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
      console.log('publicKey=<' , publicKey , '>');
      self.pubKey = publicKey;
      self.notifyPubKey(publicKey);
    })
    .catch(function(err){
      console.error(err);
    });
    this.rsPubKey = KEYUTIL.getKey(key);
    console.log('this.rsPubKey=<',this.rsPubKey ,'>');
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

  verifyAuth(content,auth,channel,cb) {
    let keys= StarBian.getRemoteKey();
    //console.log('verifyAuth:auth.pubKeyB58=<',auth.pubKeyB58,'>');
    let index = keys.indexOf(auth.pubKeyB58);
    //console.log('verifyAuth:index=<',index,'>');
    if(index === -1 && channel !== 'broadcast') {
      console.log('verifyAuth: not authed !!! index=<',index,'>');
      console.log('verifyAuth: not authed !!!  channel=<',channel,'>');
      console.log('verifyAuth: not authed !!! content=<',content,'>');
      console.log('verifyAuth: not auth !!!  auth=<',auth,'>');
      return;
    }
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
  sharePubKey(cb) {
    this.sharePubKeyCounter = 10;
    this.OneTimePassword_ = Math.floor(Math.random()*(9999-1111)+1111);
    this.OneTimeCB_ = cb;
    let self = this;
    setTimeout(function() {
      self.OneTimeCB_(self.sharePubKeyCounter,self.OneTimePassword_);
      self.sharePubKeyTimeOut_();
    },0);
  }
  searchPubKey(password,cb) {
    this.targetPubKeyPassword_ = password;
    this.targetPubKeyCallback_ = cb;
  }
  
  

  
  // private..
  sharePubKeyTimeOut_(cb) {
    this.sharePubKeyInside_();
    this.OneTimeCB_(this.sharePubKeyCounter);
    this.sharePubKeyCounter--;
    if(this.sharePubKeyCounter >= 0) {
      let self = this;
      setTimeout(function() {
        self.sharePubKeyTimeOut_(cb);
      },10000);
    }
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
    //console.log('onNotifyMessage_:jsonMsg=<',jsonMsg,'>');
    if(jsonMsg && jsonMsg.msg) {
      this.onWssMessage_(jsonMsg.msg,jsonMsg.channel);
    } else {
      console.log('onNotifyMessage_:evt.data=<',evt.data,'>');
    }
  }
  onNotifyClose_(evt) {
    console.log('onNotifyClose_:evt=<',evt,'>');
  }
  onNotifyError_(evt) {
    console.log('onNotifyError_:evt=<',evt,'>');
  }  

  onWssMessage_(msg,channel) {
    //console.log('onWssMessage_:msg=<',msg,'>');
    if(msg.auth) {
      let self = this;
      let content = msg.encrypt || msg.ecdh || msg.subscribe || msg.shareKey;
      _insideCrypto.verifyAuth(content,msg.auth,channel,() => {
        if(msg.msg) {
          self.onGoodMessage_(msg.msg);
        } else if(msg.encrypt) {
          self.onEncrypt_(msg.encrypt);
        } else if(msg.ecdh) {
          self.onGoodECDH_(msg.ecdh);
        } else if(msg.shareKey) {
          self.onShareKey_(msg.shareKey);
        } else {
          console.log('onWssMessage_ not supported  :msg=<',msg,'>');
        }
      });
    }
  }

  onGoodMessage_(msg) {
    //console.log('onGoodMessage_:msg=<',msg,'>');
    if(typeof this.subscribe_ === 'function') {
      this.subscribe_(msg);
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
  onEncrypt_(encrypt) {
    //console.log('onEncrypt_:encrypt=<',encrypt,'>');
    let self = this;
    _insideCrypto.decrypt(encrypt,function(plainMsg) {
      //console.log('onEncrypt_:typeof plainMsg=<',typeof plainMsg,'>');
      if(plainMsg) {
        if(typeof plainMsg === 'string') {
          self.onGoodMessage_(JSON.parse(plainMsg));
        } else {
          self.onGoodMessage_(plainMsg);
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

  sharePubKeyInside_() {	
    console.log('sharePubKeyInside_:_insideCrypto.pubKeyB58=<',_insideCrypto.pubKeyB58,'>');	
    if(!_insideCrypto.pubKeyB58) {	
      return;	
    } 	
    let shareKey = { 
      pubkey:_insideCrypto.pubKeyB58,
      password:this.OneTimePassword_
    };
    let self = this;
    _insideCrypto.signAuth(JSON.stringify(shareKey),function(auth) {	
      let sentMsg = {	
        channel:'broadcast',	
        auth:auth,
        shareKey:shareKey	
      };	
      //console.log('sharePubKeyInside_:self.ws_.readyState=<',self.ws_.readyState,'>');	
      if(self.ws_.readyState) {	
        //console.log('sharePubKeyInside_:sentMsg=<',sentMsg,'>');	
        self.ws_.send(JSON.stringify(sentMsg));	
      }	
    });	
  }

  
  tryExchangeKey_(type) {
    if(!this.channelKey_) {
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

  onShareKey_(shareKey) {
    //console.log('onShareKey_ shareKey =<' , shareKey ,'>');
    //console.log('onShareKey_ this.targetPubKeyPassword_ =<' , this.targetPubKeyPassword_ ,'>');
    //console.log('onShareKey_ typeof this.targetPubKeyCallback_ =<' , typeof this.targetPubKeyCallback_,'>');
    if(this.targetPubKeyPassword_ === shareKey.password.toString()) {
      if(typeof this.targetPubKeyCallback_ === 'function') {
        this.targetPubKeyCallback_(shareKey.pubkey);
        this.sharePubKeyCounter = 0;
      }
    }
  }

};


</script>
