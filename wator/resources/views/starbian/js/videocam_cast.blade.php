<script type="text/javascript">
let keyChannel = false;
function onNotifyReady() {
  let params = location.pathname.split('/');
  let key = params[params.length -1];
  console.log('onNotifyReady:key=<',key,'>');
  if(key) {
    keyChannel = key;
    sendMsg(key,{start:true});
    startCamera();
  }  
}
const configuration = {
  iceServers: [
    {urls: 'stun:stun.l.google.com:19302'},
    {urls: 'stun:stun1.l.google.com:19302'},
    {urls: 'stun:stun2.l.google.com:19302'}
  ]
};
const pc = new RTCPeerConnection(configuration);
pc.onicecandidate = ({candidate}) => { 
  console.log('onicecandidate:candidate=<',candidate,'>');
}
function startCamera() {
  let option = {video: true, audio: true}
  navigator.getUserMedia(option, onStreamGot,onStreamError)
}
function onStreamGot(stream) {
  console.log('onStreamGot:stream=<',stream,'>');
  console.log('onStreamGot:pc=<',pc,'>');
}
function onStreamError(error) {
  console.log('onStreamError:error=<',error,'>');
}
</script>
