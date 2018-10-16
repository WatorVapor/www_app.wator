<!--
<script src='https://code.responsivevoice.org/responsivevoice.js'></script>
<script type="text/javascript">
  SayResponsiveVoice = (text,lang) => {
    responsiveVoice.speak(text, lang);
  }
</script>
-->


<script type="text/javascript">

const STAIBIAN_CAMERA_HELLO_RECV_TEXT = [
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
  let voices = speechSynthesis.getVoices();
  console.log('sayHello: voices=<',voices,'>');
  if(voices.length < 1) {
    let maxRandom = STAIBIAN_CAMERA_HELLO_RECV_TEXT.length;
    let index = Math.floor(Math.random()*(maxRandom));
    let txt = STAIBIAN_CAMERA_HELLO_RECV_TEXT[index];
    if(gLinuxTTS) {
      gLinuxTTS.say(txt,"Chinese Male");
    }
    return;
  }
  console.log('sayCheckDoorCamera: speechSynthesis.speaking=<',speechSynthesis.speaking,'>');
  if(speechSynthesis.speaking) {
    console.warn('sayCheckDoorCamera: speechSynthesis.speaking=<',speechSynthesis.speaking,'>');
    speechSynthesis.cancel();
    return;
  }
  let maxRandom = STAIBIAN_CAMERA_HELLO_RECV_TEXT.length;
  let index = Math.floor(Math.random()*(maxRandom));
  let txt = STAIBIAN_CAMERA_HELLO_RECV_TEXT[index];
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
  let maxRandom = STAIBIAN_CAMERA_HELLO_RECV_TEXT.length;
  let index = Math.floor(Math.random()*(maxRandom));
  let txt = STAIBIAN_CAMERA_HELLO_RECV_TEXT[index];
  androidTTS.say(txt,0.1);
}


onSayByeBye = () => {
  sayByeBye();
  ForbiddenTalking = true;
  setTimeout(() => {
    ForbiddenTalking = false;
  },FaceDetectForbiddenIntervalMS)
}

const STAIBIAN_CAMERA_HELLO_CAST_TEXT = [
  'こんにちは、呼び出します。',
  '毎度お疲れ様です。呼び出します',
  '少々お待ちください。'
];


sayHello = () => {
  sayTTS(STAIBIAN_CAMERA_HELLO_CAST_TEXT);
}

const STAIBIAN_CAMERA_BYE_CAST_TEXT = [
  '主人は、不在と思います',
];


sayByeBye = () => {
  sayTTS(STAIBIAN_CAMERA_BYE_CAST_TEXT);
}


sayTTS = (text_array) => {
  //console.log('sayTTS: speechSynthesis.speaking=<',speechSynthesis.speaking,'>');
  try {
    //console.log('sayTTS: speechSynthesis.speaking=<',speechSynthesis.speaking,'>');
    if(!speechSynthesis) {
      sayHelloAndroid(text_array);
      return;
    }
  } catch(e) {
    sayHelloAndroid(text_array);
    return;
  }
  let voices = speechSynthesis.getVoices();
  console.log('sayTTS: voices=<',voices,'>');
  if(voices.length < 1) {
    let maxRandom = text_array.length;
    let index = Math.floor(Math.random()*(maxRandom));
    let txt = text_array[index];
    console.log('sayTTS: txt=<',txt,'>');
    try {
      if(gLinuxTTS) {
        console.log('sayTTS: gLinuxTTS=<',gLinuxTTS,'>');
        gLinuxTTS.say(txt,"Japanese Male");
      }
    } catch(e) {
      console.error('sayTTS: e=<',e,'>');
    }
    return;
  }
  console.log('sayTTS: speechSynthesis.speaking=<',speechSynthesis.speaking,'>');
  if(speechSynthesis.speaking) {
    console.warn('sayTTS: speechSynthesis.speaking=<',speechSynthesis.speaking,'>');
    speechSynthesis.cancel();
    return;
  }
  
  let maxRandom = text_array.length;
  let index = Math.floor(Math.random()*(maxRandom));
  let txt = text_array[index];
  let uttr = new SpeechSynthesisUtterance(txt);
  uttr.lang = 'ja-JP';
  uttr.pitch  = 1.3;
  uttr.rate   = 1;
  uttr.volume = 0.5;
  uttr.voice = null;
  speechSynthesis.speak(uttr);
}
sayHelloAndroid = (text_array) => {
  let maxRandom = text_array.length;
  let index = Math.floor(Math.random()*(maxRandom));
  let txt = text_array[index];
  androidTTS.say(txt,0.1);
}

</script>

