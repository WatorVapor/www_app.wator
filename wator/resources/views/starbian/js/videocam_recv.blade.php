<script type="text/javascript">

const params = location.pathname.split('/');
const keyChannel = params[params.length -1];
let rtc = new StarBianRtc(keyChannel);

rtc.subscribeMedia( (event) => {
  console.log('subscribeMedia event=<',event,'>');
  document.getElementById("video").srcObject = event.streams[0];
});

rtc.subscribeMsg( (msg,channel) => {
  console.log('subscribeMsg msg=<',msg,'>');
  console.log('subscribeMsg channel=<',channel,'>');
  if(msg && msg.detect && msg.detect.persion) {
    sayCheckDoorCamera();
  }
});

</script>
