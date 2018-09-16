<script type="text/javascript">

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
      ctracker.localStreamStarbian = localStream;
      ctracker.start(clmVideo);
      setInterval(onGetFaceDectectCheck,5000);
    }
  });
  rtc.subscribeMsg( (msg) => {
    console.log('subscribeMsg msg=<',msg,'>');
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
    if(sum > 100) {
      sayHello();
      callMaster();
    } 
  }
};

const STAIBIAN_CAMERA_HELLO_TEXT = [
  'こんにちは、呼び出します。',
  '毎度お疲れ様です。呼び出します',
  '少々お待ちください。'
];

sayHello = () => {
  //console.log('sayHello: speechSynthesis.speaking=<',speechSynthesis.speaking,'>');
  try {
    //console.log('sayHello: speechSynthesis.speaking=<',speechSynthesis.speaking,'>');
    if(!speechSynthesis) {
      sayHelloAndroid();
      return;
    }
  } catch(e) {
    sayHelloAndroid();
    return;
  }
  console.log('sayHello: speechSynthesis.speaking=<',speechSynthesis.speaking,'>');
  if(speechSynthesis.speaking) {
    console.warn('sayHello: speechSynthesis.speaking=<',speechSynthesis.speaking,'>');
    speechSynthesis.cancel();
    return;
  }
  let voices = speechSynthesis.getVoices();
  //console.log('sayHello: voices=<',voices,'>');
  let maxRandom = STAIBIAN_CAMERA_HELLO_TEXT.length;
  let index = Math.floor(Math.random()*(maxRandom));
  let txt = STAIBIAN_CAMERA_HELLO_TEXT[index];
  let uttr = new SpeechSynthesisUtterance(txt);
  uttr.lang = 'ja-JP';
  uttr.pitch  = 1.3;
  uttr.rate   = 1;
  uttr.volume = 1;
  uttr.voice = null;

  uttr.onstart = (evt) => {
    //console.log('sayHello uttr.onstart evt=<',evt,'>');
  };
  uttr.onpause = (evt) => {
    //console.log('sayHello uttr.onpause evt=<',evt,'>');
  };
  uttr.onerror = (evt) => {
    //console.log('sayHello uttr.onerror evt=<',evt,'>');
  };
  uttr.onboundary = (evt) => {
    //console.log('sayHello uttr.onboundary evt=<',evt,'>');
  };

  uttr.onend　=　(evt) => {
    //console.log('sayHello uttr.onend evt=<',evt,'>');
  };
  speechSynthesis.speak(uttr);
}
sayHelloAndroid = () => {
  let maxRandom = STAIBIAN_CAMERA_HELLO_TEXT.length;
  let index = Math.floor(Math.random()*(maxRandom));
  let txt = STAIBIAN_CAMERA_HELLO_TEXT[index];
  androidTTS.say(txt);
}

</script>
