<script>
  var Module = {
     wasmBinaryFile: 'https://huningxin.github.io/opencv.js/build/wasm/opencv_js.wasm',
    preRun: [function() {
      Module.FS_createPreloadedFile('/', 'haarcascade_eye.xml', 'https://raw.githubusercontent.com/opencv/opencv/master/data/haarcascades/haarcascade_eye.xml', true, false);
      Module.FS_createPreloadedFile('/', 'haarcascade_frontalface_default.xml', 'https://raw.githubusercontent.com/opencv/opencv/master/data/haarcascades/haarcascade_frontalface_default.xml', true, false);
      Module.FS_createPreloadedFile('/', 'haarcascade_profileface.xml', 'https://raw.githubusercontent.com/opencv/opencv/master/data/haarcascades/haarcascade_profileface.xml', true, false);
    }],
    _main: function() {opencvIsReady();}
  };
</script>
<script async src="https://huningxin.github.io/opencv.js/build/wasm/opencv.js">
    function opencvIsReady() {
        console.log('opencvIsReady');
    }
</script>






<script type="text/javascript">
const FACE_LINE_POINT_SUM_MIN = 80;
$(document).ready(function(){
  onInitVideoCam();
});
onInitVideoCam = () => {
  let elemKey = document.getElementById('wator-remote-key');
  const keyChannel = elemKey.textContent.trim();
  console.log('keyChannel=<' , keyChannel , '>');
  if(keyChannel) {
    createWebRTCConnection(keyChannel);
  } else {
    let remotekeys = StarBian.getRemoteKey();
    console.log('remotekeys=<' , remotekeys , '>');
    for(let i = 0;i < remotekeys.length;i++) {
      createWebRTCConnection(remotekeys[i]);
    }
  }
}
let rtcConnectionList = [];
createWebRTCConnection = (keyChannel) => {
  let rtc = new StarBianRtc(keyChannel,'offer');
  rtc.subscribeMedia( (event) => {
    console.log('subscribeMedia event=<',event,'>');
    //document.getElementById("video").srcObject = event.streams[0];
  });
  rtc.subscribeLocalMedia((localStream) => {
    console.log('subscribeMedia localStream=<',localStream,'>');
    if(!ctracker.localStreamStarbian) {
      let cvVideo = document.getElementById("video-opencv");
      cvVideo.srcObject = localStream;
      setInterval(onGetFaceDectectCheck,2000);
    }
  });
  rtc.subscribeMsg( (msg,channel) => {
    console.log('subscribeMsg msg=<',msg,'>');
    console.log('subscribeMsg channel=<',channel,'>');
  });
  rtcConnectionList.push(rtc);
}
callMaster = () => {
  console.log('callMaster rtcConnectionList=<',rtcConnectionList,'>');
  for(let i = 0;i < rtcConnectionList.length;i++) {
    let rtc = rtcConnectionList[i];
    if(rtc.starbian_ && rtc.starbian_.isReady ) {
      let msg = {detect:{persion:true}};
      rtc.starbian_.publish(msg);
    }
  }
}

const FaceDetectNotifyIntervalMS = 1000 * 5;
let prevFaceDetectTime = new Date();
let sayByebyeTimeout = false;
let ForbiddenTalking = false;
const FaceDetectSayByeIntervalMS = 1000 * 100;
const FaceDetectForbiddenIntervalMS= 1000 * 100;
onGetFaceDectectCheck = () => {
};
</script>
