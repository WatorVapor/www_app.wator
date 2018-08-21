<script type="text/javascript">

const params = location.pathname.split('/');
const keyChannel = params[params.length -1];
console.log('keyChannel=<',keyChannel,'>');
let notify = new WatorNotify(keyChannel);
notify.onReady = () => {
  notify.publish({start:true});
  startCamera();
};
notify.subcribe( (msg) => {
  console.log('notify.subcribe:msg=<',msg,'>');
});

console.log('notify=<',notify,'>');



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
  navigator.mediaDevices.getUserMedia(option, onStreamGot,onStreamError)
}
function onStreamGot(stream) {
  console.log('onStreamGot:stream=<',stream,'>');
  console.log('onStreamGot:pc=<',pc,'>');
}
function onStreamError(error) {
  console.log('onStreamError:error=<',error,'>');
}
</script>
