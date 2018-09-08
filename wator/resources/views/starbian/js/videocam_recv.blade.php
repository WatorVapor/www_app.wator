<script type="text/javascript">

const params = location.pathname.split('/');
const keyChannel = params[params.length -1];
let rtc = new StarBianRtc(keyChannel);

rtc.subscribeMedia( (event) => {
  console.log('subscribeMedia event=<',event,'>');
  document.getElementById("video").srcObject = event.streams[0];
});

/*
starbian.isReady = false;

starbian.onReady = () => {
  starbian.publish({start:true});
  starbian.isReady = true;
};
starbian.subscribe( (msg) => {
  console.log('starbian.subcribe:msg=<',msg,'>');
  if(msg && msg.offer) {
    onRemoteOffer(msg.offer);
  }
  if(msg && msg.ice) {
    onRemoteICE(msg.ice);
  }
});

console.log('starbian=<',starbian,'>');



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
  };
  pc.ontrack = (event) => {
    console.log('ontrack:event=<',event,'>');
    document.getElementById("video").srcObject = event.streams[0];
  };
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
  if(starbian.isReady) {
    starbian.publish({answer:answer});
  } else {
    console.log('sendAnswer wrong times!!!!:answer=<',answer,'>');
  }
}


function sendICE(ice) {
  if(starbian.isReady) {
    starbian.publish({ice:ice});
  } else {
    console.log('sendICE wrong times!!!!:ice=<',ice,'>');
  }
}

function onRemoteICE(ice) {
  console.log('onRemoteICE:typeof ice=<',typeof ice,'>');  
  console.log('onRemoteICE:ice=<',ice,'>');  
  pc.addIceCandidate( new RTCIceCandidate(ice));
}
*/


</script>
