<script type="text/javascript">

class StarBian {
  constructor(channelKey) {
    let uri = "wss://www.wator.xyz/ws/starbian";
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
    this.counter = 10;
    let self = this;
    setTimeout(function() {
      self.sharePubKeyTimeOut_(cb);
    },0);
  }
  sharePubKeyTimeOut_(cb) {
    this.sharePubKeyInside_(cb);
    cb(this.counter);
    this.counter--;
    if(this.counter > 0) {
      let self = this;
      setTimeout(function() {
        self.sharePubKeyTimeOut_(cb);
      },10000);
    }
  }
  
  
  // private..
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
      this.onWssMessage_(jsonMsg.msg);
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

  onWssMessage_(msg) {
    //console.log('onWssMessage_:msg=<',msg,'>');
    if(msg.auth) {
      let self = this;
      this.verifyAuth_(msg.auth,function(good){
        //console.log('onWssMessage_:good=<',good,'>');
        if(good) {
          if(msg.msg) {
            self.onGoodMessage_(msg.msg);
          } else if(msg.encrypt) {
            self.onEncrypt_(msg.encrypt);
          } else if(msg.ecdh) {
            self.onGoodECDH_(msg.ecdh);
          } else {
            console.log('onWssMessage_ not supported  :msg=<',msg,'>');
          }
        } else {
          console.log('onWssMessage_ not auth :msg=<',msg,'>');
        }
      });
    }
  }
  verifyAuth_(auth,cb) {
    //console.log('verifyAuth_:auth=<',auth,'>');
    let keys= WATOR.getRemoteKeys();
    //console.log('verifyAuth_:auth.pubKeyHex=<',auth.pubKeyHex,'>');
    let index = keys.indexOf(auth.pubKeyHex);
    //console.log('verifyAuth_:index=<',index,'>');
    if(index !== -1) {
      //console.log('verifyAuth_:auth.pubKey=<',auth.pubKey,'>');
      WATOR.verify(auth.pubKey,auth.hash,auth.sign,cb);
    } else {
      cb(false);
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
    console.log('subscribeChannel_:WATOR.pubKeyHex=<',WATOR.pubKeyHex,'>');	
    if(!WATOR.pubKeyHex) {	
      return;	
    } 	
    let subs = { ts:new Date()};
    let self = this;
    WATOR.sign(JSON.stringify(subs),function(auth) {	
      let sentMsg = {	
        channel:WATOR.pubKeyHex,	
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
    console.log('sharePubKeyInside_:WATOR.pubKeyHex=<',WATOR.pubKeyHex,'>');	
    if(!WATOR.pubKeyHex) {	
      return;	
    } 	
    let shareKey = { 
      pubkey:WATOR.pubKeyHex,
      ts:new Date()
    };
    let self = this;
    WATOR.sign(JSON.stringify(shareKey),function(auth) {	
      let sentMsg = {	
        channel:'broadcast',	
        auth:auth,
        shareKey:shareKey	
      };	
      //console.log('sharePubKeyInside_:self.ws_=<',self.ws_,'>');	
      if(self.ws_.readyState) {	
        self.ws_.send(JSON.stringify(sentMsg));	
      }	
    });	
  }

  
  tryExchangeKey_(type) {
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

};

</script>
