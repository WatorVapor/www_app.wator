<script type="text/javascript">
'use strict'

$(document).ready(function(){
  setTimeout(function(){
    StarBian_.InitCrypto_();
  },0);
});



/**
* @classdesc This is StarBian_.
* @constructor
* @param {string} channelKey
*/
class StarBian_ {
  constructor(channelKey) {
    this.ipfsProxy = new StarBianIpfsProxy(channelKey);
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
  }
  /**
  * @param {string} key
  */
  static addRemoteKey(key) {
  }
  /**
  * @param {string} key
  */
  static removeRemoteKey(key) {
  }
  
  
  // private..
  static InitCrypto_(evt) {
    if(!_insideCrypto) {
      _insideCrypto = new StarBianCrypto();
    }
  }
}

// private class

const LS_KEY_NAME = 'wator-starbian-ecdsa-key';
const LS_KEY_REMOTE_NAME = 'wator-starbian-ecdsa-remote-keys';

class StarBianCrypto {
  constructor() {
    //console.log('StarBianCrypto');	
    let key = localStorage.getItem(LS_KEY_NAME);
    //console.log('StarBianCrypto:key=<',key,'>');
    if(key) {
      onLoadSavedKey(key);
    } else {
      onCreateKey();
    }  
    let keyRemote = localStorage.getItem(LS_KEY_REMOTE_NAME);
    if(!keyRemote) {
      let keyStr = JSON.stringify([]);
      //console.log('StarBianCrypto keyStr=<' , keyStr , '>');
      localStorage.setItem(LS_KEY_REMOTE_NAME,keyStr);
    }
    createECDHKey();
    /*
    if(typeof StarBian_.onReadOfKey === 'function') {
      StarBian_.onReadOfKey('ok');
    }
    */
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
      getPubKey(key.publicKey);
      self.prvKey = key.privateKey;
      savePrivKey(key.privateKey);
    })
    .catch(function(err){
      console.error(err);
    });
  }
  
}
let _insideCrypto = false; 

/**
* @classdesc This is StarBian.
* @constructor
*/
class StarBian {
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
    WATOR.encrypt(JSON.stringify(msg),function(encrypt) {
      //console.log('publish:encrypt=<',encrypt,'>');	
      WATOR.sign(JSON.stringify(encrypt),function(auth) {
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
      this.verifyAuth_(msg.auth,content,channel,() => {
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
  verifyAuth_(auth,content,channel,cb) {
    //console.log('verifyAuth_:auth=<',auth,'>');
    //console.log('verifyAuth_:content=<',content,'>');
    //console.log('verifyAuth_:channel=<',channel,'>');
    WATOR.verify(content,auth,channel,cb);
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
    WATOR.exchangeKey(ecdh.key,function(keyAes) {
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
    WATOR.decrypt(encrypt,function(plainMsg) {
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
    console.log('subscribeChannel_:WATOR.pubKeyB58=<',WATOR.pubKeyB58,'>');	
    if(!WATOR.pubKeyB58) {	
      return;	
    } 	
    let subs = { ts:new Date()};
    let self = this;
    WATOR.sign(JSON.stringify(subs),function(auth) {	
      let sentMsg = {	
        channel:WATOR.pubKeyB58,	
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
    console.log('sharePubKeyInside_:WATOR.pubKeyB58=<',WATOR.pubKeyB58,'>');	
    if(!WATOR.pubKeyB58) {	
      return;	
    } 	
    let shareKey = { 
      pubkey:WATOR.pubKeyB58,
      password:this.OneTimePassword_
    };
    let self = this;
    WATOR.sign(JSON.stringify(shareKey),function(auth) {	
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
      key:WATOR.ECDHKeyPubJwk,
      type:type,
      ts:new Date()
    };
    let self = this;
    WATOR.sign(JSON.stringify(ecdh),function(auth) {
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
