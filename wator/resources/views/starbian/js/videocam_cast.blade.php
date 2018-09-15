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
    } 
  }
};

const STAIBIAN_CAMERA_HELLO_TEXT = [
  'こんにちは、呼び出します。',
  '毎度お疲れ様です。呼び出します',
  '少々お待ちください。'
];

sayHello = () => {
  if(!speechSynthesis) {
    sayHelloAndroid();
    return;
  }
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
