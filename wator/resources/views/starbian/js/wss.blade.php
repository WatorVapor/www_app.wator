<script type="text/javascript">
let uri = "wss://www.wator.xyz/ws/starbian";
let ws = new WebSocket(uri);
ws.onopen = onNotifyOpen_;
ws.onmessage = onNotifyMessage_;
ws.onclose = onNotifyClose_;
ws.onerror = onNotifyError_;
function onNotifyOpen_(evt) {
  console.log('onNotifyOpen_:evt=<',evt,'>');
  setTimeout(function(){
    _subscribe();
  },1000+10);
  setTimeout(function() {
    if(typeof onNotifyReady === 'function') {
      onNotifyReady();
    }
  },1000+20);
}
function onNotifyMessage_(evt) {
  //console.log('onNotifyMessage_:evt.data=<',evt.data,'>');
  let jsonMsg = JSON.parse(evt.data);
  //console.log('onNotifyMessage_:jsonMsg=<',jsonMsg,'>');
  if(jsonMsg && jsonMsg.msg) {
    _onWssMessage(jsonMsg.msg);
  } else {
    console.log('onNotifyMessage_:evt.data=<',evt.data,'>');
  }
}
function onNotifyClose_(evt) {
  console.log('onNotifyClose_:evt=<',evt,'>');
}
function onNotifyError_(evt) {
  console.log('onNotifyError_:evt=<',evt,'>');
}

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

function _subscribe() {
  console.log('_subscribe:WATOR.pubKeyHex=<',WATOR.pubKeyHex,'>');
  if(!WATOR.pubKeyHex) {
    return;
  } 
  let subs = { ts:new Date()};
  WATOR.sign(JSON.stringify(subs),function(auth) {
    let sentMsg = {
      channel:WATOR.pubKeyHex,
      auth:auth,
      subscribe:subs
    };
    //console.log('_subscribe:ws=<',ws,'>');
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
