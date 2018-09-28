@extends('wator.app')
@section('content')
<script src="/wator/starbian/js/starbian.js" type="text/javascript"></script>
@include('starbian.js.m_localstorage')

<script type="text/javascript">

$(document).ready(function(){
  onInitMonitor();
});

onInitMonitor = () => {
let remotekeys = StarBian.getRemoteKey();
  console.log('remotekeys=<' , remotekeys , '>');
  for(let i = 0;i < remotekeys.length;i++) {
    createStarBian(remotekeys[i]);

  }
}
let sbConnectionList = []; 
createStarBian = (keyChannel) => {

  let starbian = new StarBian.Peer(keyChannel);
  starbian.isReady = false;
  starbian.onReady = () => {
  };
  starbian.subscribe( (msg) => {
    console.log('starbian.subcribe:msg=<',msg,'>');
  });
  console.log('starbian=<',starbian,'>');
  sbConnectionList.push(starbian);
}



const STAIBIAN_CAMERA_HELLO_TEXT = [
  '门口来人了，快看看去。',
  '主人，来客人了。'
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


@endsection
