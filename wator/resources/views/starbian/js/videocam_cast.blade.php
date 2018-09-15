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

let isSpeaking = false;
sayHello = () => {
  if(isSpeaking) {
    console.warn('sayHello: isSpeaking=<',isSpeaking,'>');
    return;
  }
  let voices = speechSynthesis.getVoices();
  console.log('sayHello: voices=<',voices,'>');
  isSpeaking = true;
  let txt = 'こんにちは、呼び出します。';
  let uttr = new SpeechSynthesisUtterance(txt);
  uttr.lang = 'ja-JP';
  uttr.pitch  = 1.3;
  uttr.rate   = 1;
  uttr.volume = 1;
  uttr.voice = null;

  uttr.onend　=　(evt) => {
    isSpeaking = false;
  };
  speechSynthesis.speak(uttr);
}

</script>
