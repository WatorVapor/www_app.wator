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
const pc = new RTCPeerConnection(configuration);
pc.onicecandidate = ({candidate}) => { 
  console.log('onicecandidate:candidate=<',candidate,'>');
}

function onRemoteOffer(offer) {
  console.log('onRemoteOffer:offer=<',offer,'>');  
}
function onRemoteICE(ice) {
  console.log('onRemoteICE:ice=<',ice,'>');  
}


</script>
