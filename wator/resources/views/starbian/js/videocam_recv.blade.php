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


const STAIBIAN_CAMERA_HELLO_TEXT = [
  '主人，来客人了。',
  '主人，来客人了。',
  '主人，来客人了。',
  '主人，来客人了。',
  '主人，来客人了。',
  '主人，来客人了。',
  '主人，来客人了。',
  '主人，来客人了。',
  '懒鬼，有人来了。',
];
sayCheckDoorCamera = () => {
  //console.log('sayCheckDoorCamera: speechSynthesis.speaking=<',speechSynthesis.speaking,'>');
  try {
    //console.log('sayCheckDoorCamera: speechSynthesis.speaking=<',speechSynthesis.speaking,'>');
    if(!speechSynthesis) {
      sayCheckDoorCameraAndroid();
      return;
    }
  } catch(e) {
    sayCheckDoorCameraAndroid();
    return;
  }
  console.log('sayCheckDoorCamera: speechSynthesis.speaking=<',speechSynthesis.speaking,'>');
  if(speechSynthesis.speaking) {
    console.warn('sayCheckDoorCamera: speechSynthesis.speaking=<',speechSynthesis.speaking,'>');
    speechSynthesis.cancel();
    return;
  }
  let voices = speechSynthesis.getVoices();
  console.log('sayCheckDoorCamera: voices=<',voices,'>');
  let maxRandom = STAIBIAN_CAMERA_HELLO_TEXT.length;
  let index = Math.floor(Math.random()*(maxRandom));
  let txt = STAIBIAN_CAMERA_HELLO_TEXT[index];
  let uttr = new SpeechSynthesisUtterance(txt);
  uttr.lang = 'zh-CN';
  uttr.pitch  = 1.3;
  uttr.rate   = 1;
  uttr.volume = 1;
  uttr.voice = null;
  uttr.onstart = (evt) => {
    //console.log('sayCheckDoorCamera uttr.onstart evt=<',evt,'>');
  };
  uttr.onpause = (evt) => {
    //console.log('sayCheckDoorCamera uttr.onpause evt=<',evt,'>');
  };
  uttr.onerror = (evt) => {
    //console.log('sayHello uttr.onerror evt=<',evt,'>');
  };
  uttr.onboundary = (evt) => {
    //console.log('sayCheckDoorCamera uttr.onboundary evt=<',evt,'>');
  };
  uttr.onend　=　(evt) => {
    //console.log('sayCheckDoorCamera uttr.onend evt=<',evt,'>');
  };
  speechSynthesis.speak(uttr);
}

sayCheckDoorCameraAndroid = () => {
  let maxRandom = STAIBIAN_CAMERA_HELLO_TEXT.length;
  let index = Math.floor(Math.random()*(maxRandom));
  let txt = STAIBIAN_CAMERA_HELLO_TEXT[index];
  androidTTS.say(txt);
}

</script>
