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
      if(typeof self.onReady === 'function') {
        self.onReady();
      }
    },1000+20);
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
  
};




function sendMsg(channel,msg) {
  msg.ts = new Date();
  WATOR.sign(JSON.stringify(msg),function(auth) {
    let sentMsg = {
      channel:channel,
      auth:auth,
      msg:msg
    };
    if(ws.readyState) {
      ws.send(JSON.stringify(sentMsg));
    }
  });
}


function tryExchangeKey(channel) {
  let ecdh = { ts:new Date()};
  WATOR.sign(JSON.stringify(subs),function(auth) {
    let sentMsg = {
      channel:channel,
      auth:auth,
      ecdh:subs
    };
    //console.log('tryExchangeKey:ws=<',ws,'>');
    if(ws.readyState) {
      ws.send(JSON.stringify(sentMsg));
    }
  });


}


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

function _onWssMessage(msg) {
  console.log('_onWssMessage:msg=<',msg,'>');
  if(msg.auth) {
    _verifyAuth(msg.auth,function(good){
      console.log('_onWssMessage:good=<',good,'>');
      if(good) {
        _onGoodMessage(msg.msg);
      } else {
        console.log('_onWssMessage not auth :msg=<',msg,'>');
      }
    });
  }
}

function _verifyAuth(auth,cb) {
  console.log('_verifyAuth:auth=<',auth,'>');
  console.log('_verifyAuth:auth.pubKey=<',auth.pubKey,'>');
  let keys= WATOR.getRemoteKeys();
  let index = keys.indexOf(auth.pubKey);
  console.log('_verifyAuth:index=<',index,'>');
  if(index !== -1) {
    WATOR.verify(auth.pubKey,auth.hash,auth.sign,cb);
  } else {
    cb(false);
  }
}

function _onGoodMessage(msg) {
  console.log('_onGoodMessage:msg=<',msg,'>');
}
</script>
