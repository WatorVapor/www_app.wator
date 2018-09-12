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
      let clmVideo = document.getElementById("video-clmtrackr");
      clmVideo.srcObject = localStream;
      ctracker.localStreamStarbian = localStream;
      ctracker.start(clmVideo);
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
  if(positions && positions.length) {
    for(let i = 1;i < positions.length ;i++) {
      let pos1 = positions[i -1];
      let pos2 = positions[i];
      console.log('onGetFaceDectectCheck: pos1=<',pos1,'>');
      console.log('onGetFaceDectectCheck: pos2=<',pos2,'>');
    }
  }
};

</script>
