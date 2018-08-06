<script type="text/javascript">

let uri = "wss://www.wator.xyz/ws/starbian";
let ws = new WebSocket(uri);
ws.onopen = onNotifyOpen_;
ws.onmessage = onNotifyMessage_;
ws.onclose = onNotifyClose_;
ws.onerror = onNotifyError_;
function onNotifyOpen_(evt) {
  console.log('onNotifyOpen_:evt=<',evt,'>');
  subscribe();
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
  console.log('onNotifyOpen_:WATOR.pubKeyHex=<',WATOR.pubKeyHex,'>');
  if(WATOR.pubKeyHex) {
    let sentMsg = {
      channel:WATOR.pubKeyHex,
      subscribe:true
    };
    console.log('onNotifyOpen_:ws=<',ws,'>');
    if(ws.readyState) {
      ws.send(JSON.stringify(sentMsg));
    }
  }
}

</script>
