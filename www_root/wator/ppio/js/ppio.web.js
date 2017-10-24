var uri = 'wss://' + location.host + '/ws/starbian';
console.log('uri =<',uri,'>');
var ws = new WebSocket(uri);
ws.onopen = onOpen;
ws.onmessage = onMessage;
ws.onclose = onClose;
ws.onerror = onError;

function onOpen(event) {
  console.log('event =<',event,'>');
}
function onMessage(event) {
  console.log('event =<',event,'>');
}
function onError(event) {
  console.log('event =<',event,'>');
}
function onClose(event) {
  console.log('event =<',event,'>');
}
