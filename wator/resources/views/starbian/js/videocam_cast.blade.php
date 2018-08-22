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
  if(msg && msg.start) {
    startWebRTC();
  }
  if(msg && msg.answer) {
    onRemoteAnswer(msg.answer);
  }
  if(msg && msg.ice) {
    onRemoteICE(msg.ice);
  }
});
console.log('notify=<',notify,'>');




let localOfferCache = false;
let localICECache = [];

function sendLocalCache() {
  if(localOfferCache) {
    notify.publish({offer:localOfferCache});
  }
  if(localICECache) {
    notify.publish({ice:localICECache});
  }
}

const configuration = {
  iceServers: [
    {urls: 'stun:stun.l.google.com:19302'},
    {urls: 'stun:stun1.l.google.com:19302'},
    {urls: 'stun:stun2.l.google.com:19302'}
  ]
};
startCamera();

let localStreamCache = false;


function startCamera() {
  let option = {video: true, audio: true}
  console.log('startCamera=<',option,'>');
  let pMedia = navigator.mediaDevices.getUserMedia(option);
  pMedia.then(onStreamGot);
  pMedia.catch(onStreamError);
}
function onStreamError(error) {
  console.log('onStreamError:error=<',error,'>');
}

function onStreamGot(stream) {
  console.log('onStreamGot:stream=<',stream,'>');
  localStreamCache = stream;
}
let pc = false;
function startWebRTC() {
  console.log('onStreamGot:pc=<',pc,'>');
  if(localStreamCache) {
  }

  pc = new RTCPeerConnection(configuration);
  pc.onicecandidate = ({candidate}) => { 
    console.log('onicecandidate:candidate=<',candidate,'>');
    if(candidate) {
      sendICE(candidate);
    }
  }
  pc.addStream(stream);
  let pOffer = pc.createOffer();
  pOffer.then(onOfferGot);
  pOffer.catch(onOfferError);
}

function onOfferError(error) {
  console.log('onOfferError:error=<',error,'>');
}
function onOfferGot(offer) {
  console.log('onOfferGot:offer=<',offer,'>');
  pc.setLocalDescription(offer);
  sendOffer(offer);
}

function sendOffer(offer) {
  if(notify.isReady) {
    notify.publish({offer:offer});
  } else {
    localOfferCache = offer;
  }
}

function sendICE(ice) {
  if(notify.isReady) {
    notify.publish({ice:ice});
  } else {
    localICECache.push(ice);
  }
}

function onRemoteAnswer(answer) {
  console.log('onRemoteAnswer:answer=<',answer,'>');  
  let sdp = new RTCSessionDescription(answer);
  console.log('onRemoteAnswer:sdp=<',sdp,'>');
  let pRsdp =pc.setRemoteDescription(sdp);
  pRsdp.then(onSetRemoteDescriptionGot);
  pRsdp.catch(onSetRemoteDescriptionError);
}
function onSetRemoteDescriptionError(error) {
  console.log('onSetRemoteDescriptionError:error=<',error,'>');
}
function onSetRemoteDescriptionGot() {
}

function onRemoteICE(ice) {
  console.log('onRemoteICE:typeof ice=<',typeof ice,'>');  
  console.log('onRemoteICE:ice=<',ice,'>');  
}


</script>
