<script type="text/javascript">

class WatorNotify {
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
  
  onNotifyOpen_(evt) {
    console.log('onNotifyOpen_:evt=<',evt,'>');
    let self = this;
    setTimeout(function(){
      self.subscribe_();
    },1000+10);
    setTimeout(function() {
      self.tryExchangeKey_();
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
    console.log('onWssMessage_:msg=<',msg,'>');
    if(msg.auth) {
      let self = this;
      this.verifyAuth_(msg.auth,function(good){
        console.log('onWssMessage_:good=<',good,'>');
        if(good) {
          if(msg.msg) {
            self.onGoodMessage_(msg.msg);
          }
          if(msg.ecdh) {
            self.onGoodECDH_(msg.ecdh);
          }
        } else {
          console.log('onWssMessage_ not auth :msg=<',msg,'>');
        }
      });
    }
  }
  verifyAuth_(auth,cb) {
    console.log('verifyAuth_:auth=<',auth,'>');
    let keys= WATOR.getRemoteKeys();
    console.log('verifyAuth_:auth.pubKeyHex=<',auth.pubKeyHex,'>');
    let index = keys.indexOf(auth.pubKeyHex);
    console.log('verifyAuth_:index=<',index,'>');
    if(index !== -1) {
      console.log('verifyAuth_:auth.pubKey=<',auth.pubKey,'>');
      WATOR.verify(auth.pubKey,auth.hash,auth.sign,cb);
    } else {
      cb(false);
    }
  }

  onGoodMessage_(msg) {
    console.log('onGoodMessage_:msg=<',msg,'>');
  }
  onGoodECDH_(ecdh) {
    console.log('onGoodECDH_:ecdh=<',ecdh,'>');
    if(!this.exchangeKeyDone_) {
      this.tryExchangeKey_();
    }
    this.exchangeKeyDone_ = true;
    WATOR.exchangeKey(ecdh.key,function(keyAes) {
      console.log('onGoodECDH_:keyAes=<',keyAes,'>');
      setTimeout(function() {
        if(typeof self.onReady === 'function') {
          self.onReady();
        }
      },0);
    });
  }

  subscribe_() {	
    console.log('subscribe_:WATOR.pubKeyHex=<',WATOR.pubKeyHex,'>');	
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
      //console.log('subscribe_:self.ws_=<',self.ws_,'>');	
      if(self.ws_.readyState) {	
        self.ws_.send(JSON.stringify(sentMsg));	
      }	
    });	
  }

  sendMsg(msg,channel) {
    msg.ts = new Date();
    let self = this;
    WATOR.sign(JSON.stringify(msg),function(auth) {
      let sentMsg = {
        channel:channel,
        auth:auth,
        msg:msg
      };
      if(self.ws_.readyState) {
        self.ws_.send(JSON.stringify(sentMsg));
      }
    });
  }
  
  publish(msg) {
    msg.ts = new Date();
    let self = this;
    WATOR.sign(JSON.stringify(msg),function(auth) {
      let sentMsg = {
        channel:self.channelKey_,
        auth:auth,
        msg:msg
      };
      if(self.ws_.readyState) {
        self.ws_.send(JSON.stringify(sentMsg));
      }
    });
  }
  
  tryExchangeKey_() {
    let ecdh = {
      key:WATOR.ECDHKeyPubJwk,
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









/**
*/
function _sendMsgPrivate(channel,msg) {
  let sentMsg = {
    channel:channel,
    msg:msg
  };
  if(ws.readyState) {
    ws.send(JSON.stringify(sentMsg));
  }
}




</script>
