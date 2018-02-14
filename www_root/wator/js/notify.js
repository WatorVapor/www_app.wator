let uri = "wss://" + location.host + "/wator/notify";
let ws = new WebSocket(uri);
ws.onopen = onNotifyOpen_;
ws.onmessage = onNotifyMessage_;
ws.onclose = onNotifyClose_;
ws.onerror = onNotifyError_;

function onNotifyOpen_(evt) {
  console.log('onNotifyOpen_:evt=<',evt,'>');
}
function onNotifyMessage_(evt) {
  console.log('onNotifyMessage_:evt=<',evt,'>');
}
function onNotifyClose_(evt) {
  console.log('onNotifyClose_:evt=<',evt,'>');
}
function onNotifyError_(evt) {
  console.log('onNotifyError_:evt=<',evt,'>');
}
