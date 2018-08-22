<script type="text/javascript">

const params = location.pathname.split('/');
const keyChannel = params[params.length -1];
console.log('keyChannel=<',keyChannel,'>');
let notify = new WatorNotify(keyChannel);
notify.isReady = false;

notify.onReady = () => {
  notify.publish({start:true});
  notify.isReady = true;
};
notify.subscribe( (msg) => {
  console.log('notify.subcribe:msg=<',msg,'>');
  if(msg && msg.offer) {
    onRemoteOffer(msg.offer);
  }
  if(msg && msg.ice) {
    onRemoteICE(msg.ice);
  }
});

console.log('notify=<',notify,'>');



const configuration = {
  iceServers: [
    {urls: 'stun:stun.l.google.com:19302'},
    {urls: 'stun:stun1.l.google.com:19302'},
    {urls: 'stun:stun2.l.google.com:19302'}
  ]
};
let pc = false;
function onRemoteOffer(offer) {
  pc = new RTCPeerConnection(configuration);
  pc.onicecandidate = ({candidate}) => { 
    console.log('onicecandidate:candidate=<',candidate,'>');
    if(candidate) {
      sendICE(candidate);
    }
  }
  console.log('onRemoteOffer:offer=<',offer,'>');
  let sdp = new RTCSessionDescription(offer);
  console.log('onRemoteOffer:sdp=<',sdp,'>');
  let pRsdp =pc.setRemoteDescription(sdp);
  pRsdp.then(onSetRemoteDescriptionGot);
  pRsdp.catch(onSetRemoteDescriptionError);
}
function onSetRemoteDescriptionError(error) {
  console.log('onSetRemoteDescriptionError:error=<',error,'>');
}
function onSetRemoteDescriptionGot() {
  let pAnswer = pc.createAnswer();
  pAnswer.then(onAnswerGot);
  pAnswer.catch(onAnswerError);
}

function onAnswerError(error) {
  console.log('onAnswerError:error=<',error,'>');
}
function onAnswerGot(answer) {
  console.log('onAnswerGot:answer=<',answer,'>');
  pc.setLocalDescription(answer);
  sendAnswer(answer);
}

function sendAnswer(answer) {
  if(notify.isReady) {
    notify.publish({answer:answer});
  } else {
    console.log('sendAnswer wrong times!!!!:answer=<',answer,'>');
  }
}


function sendICE(ice) {
  if(notify.isReady) {
    notify.publish({ice:ice});
  } else {
    console.log('sendICE wrong times!!!!:ice=<',ice,'>');
  }
}

function onRemoteICE(ice) {
  console.log('onRemoteICE:typeof ice=<',typeof ice,'>');  
  console.log('onRemoteICE:ice=<',ice,'>');  
}


</script>
