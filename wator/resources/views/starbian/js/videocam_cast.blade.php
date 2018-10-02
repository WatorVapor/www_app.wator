<script type="text/javascript">
const FACE_LINE_POINT_SUM_MIN = 160;

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
      let clmVideo = document.getElementById("video-clmtrackr");
      clmVideo.srcObject = localStream;
      clmVideo.play();
      ctracker.localStreamStarbian = localStream;
      ctracker.start(clmVideo);
      setInterval(onGetFaceDectectCheck,5000);
    }
  });
  rtc.subscribeMsg( (msg,channel) => {
    console.log('subscribeMsg msg=<',msg,'>');
    console.log('subscribeMsg channel=<',channel,'>');
    if(msg && msg.app === 'restart') {
      try {
        if(androidAPP) {
          androidAPP.restart();
        }
      } catch(e) {
      }
    }
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

const ctracker = new clm.tracker();
ctracker.init();
console.log('ctracker=<',ctracker,'>');
const FaceDetectNotifyIntervalMS = 1000 * 10;
let prevFaceDetectTime = new Date();
let sayByebyeTimeout = false;
let ForbiddenTalking = false;
const FaceDetectSayByeIntervalMS = 1000 * 100;
const FaceDetectForbiddenIntervalMS= 1000 * 100;


onGetFaceDectectCheck = () => {
  let positions = ctracker.getCurrentPosition();
  //console.log('onGetFaceDectectCheck: positions=<',positions,'>');
  if(positions && positions.length) {
    let sum = 0;
    for(let i = 1;i < positions.length ;i++) {
      let pos1 = positions[i -1];
      let pos2 = positions[i];
      //console.log('onGetFaceDectectCheck: pos1=<',pos1,'>');
      //console.log('onGetFaceDectectCheck: pos2=<',pos2,'>');
      sum += Math.abs(pos2[0] - pos1[0]) + Math.abs(pos2[1] - pos1[1])
    }
    console.log('onGetFaceDectectCheck: sum=<',sum,'>');
    if(sum > FACE_LINE_POINT_SUM_MIN) {
      let now = new Date();
      let diff = now - prevFaceDetectTime;
      if(diff < FaceDetectNotifyIntervalMS) {
        return;
      }
      prevFaceDetectTime = now;
      if(!ForbiddenTalking) {
        sayHello();
        callMaster();
      }
      if(!sayByebyeTimeout) {
        sayByebyeTimeout = setTimeout(onSayByeBye,FaceDetectSayByeIntervalMS);
      }
    }
  }
};

</script>
