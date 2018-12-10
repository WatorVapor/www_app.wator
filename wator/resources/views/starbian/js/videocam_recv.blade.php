<script type="text/javascript">

const params = location.pathname.split('/');
const keyChannel = params[params.length -1];
let rtc = new StarBianRtc(keyChannel);

let remoteStream = false;
rtc.subscribeMedia( (event) => {
  console.log('subscribeMedia event=<',event,'>');
  document.getElementById("video").srcObject = event.streams[0];
  remoteStream = event.streams[0];
});

rtc.subscribeMsg( (msg,channel) => {
  console.log('subscribeMsg msg=<',msg,'>');
  console.log('subscribeMsg channel=<',channel,'>');
  if(msg && msg.detect && msg.detect.persion) {
    sayCheckDoorCamera();
    Push.create('！！！家里有人来了！！！');
  }
});

onRestartRemoteApp = (elem) => {
  console.log('onRestartRemoteApp elem=<',elem,'>');
  rtc.publish({app:'restart'});
}

onStartStream = (elem) => {
  console.log('onStartStream elem=<',elem,'>');
  if(remoteStream) {
    document.getElementById("video").srcObject = remoteStream;
  }
}

onStopStream = (elem) => {
  console.log('onStopStream elem=<',elem,'>');
  document.getElementById("video").srcObject = null;
}

</script>
