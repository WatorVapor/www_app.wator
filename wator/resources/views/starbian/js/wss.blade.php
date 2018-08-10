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
    subscribe();
  },10);
  setTimeout(function(){
    if(typeof onNotifyReady === 'function') {
      onNotifyReady();
    }
  },20);
}
function onNotifyMessage_(evt) {
  console.log('onNotifyMessage_:evt.data=<',evt.data,'>');
  let jsonMsg = JSON.parse(evt.data);
  console.log('onNotifyMessage_:jsonMsg=<',jsonMsg,'>');
  if(typeof onUpdateData === 'function' && jsonMsg) {
  }
}
function onNotifyClose_(evt) {
  console.log('onNotifyClose_:evt=<',evt,'>');
}
function onNotifyError_(evt) {
  console.log('onNotifyError_:evt=<',evt,'>');
}
function sendMsg(channel,msg) {
  let sentMsg = {
    channel:channel,
    msg:msg
  };
  if(ws.readyState) {
    ws.send(JSON.stringify(sentMsg));
  }
}

function subscribe() {
  console.log('subscribe:WATOR.pubKeyHex=<',WATOR.pubKeyHex,'>');
  if(WATOR.pubKeyHex) {
    let subs = { ts:new Date()};
    let sign = WATOR.sign(JSON.stringify(subscribe));
    let sentMsg = {
      channel:WATOR.pubKeyHex,
      sign:sign,
      subs:subs
    };
    //console.log('onNotifyOpen_:ws=<',ws,'>');
    if(ws.readyState) {
      ws.send(JSON.stringify(sentMsg));
    }
  }
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


</script>
