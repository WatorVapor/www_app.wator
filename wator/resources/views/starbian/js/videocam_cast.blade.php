<script type="text/javascript">

const params = location.pathname.split('/');
const keyChannel = params[params.length -1];
if(keyChannel) {
  let rtc = new StarBianRtc(keyChannel,'offer');
  rtc.subscribeMedia( (event) => {
    console.log('subscribeMedia event=<',event,'>');
    //document.getElementById("video").srcObject = event.streams[0];
  });
  rtc.subscribeLocalMedia((localStream) => {
    console.log('subscribeMedia localStream=<',localStream,'>');
    if(!ctracker.localStreamStarbian) {
      ctracker.localStreamStarbian = localStream;
      ctracker.start(localStream);
      setInterval(onGetFaceDectectCheck,5000);
    }
  });
}

const ctracker = new clm.tracker();
ctracker.init();
console.log('ctracker=<',ctracker,'>');

onGetFaceDectectCheck = () => {
  let positions = ctracker.getCurrentPosition();
  console.log('onGetFaceDectectCheck: positions=<',positions,'>');
};

</script>
