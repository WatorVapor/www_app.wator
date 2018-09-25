<script type="text/javascript">


const RECORD_TIME_MS = 3000;
const RECORD_INTERVAL_MS = 300;
const ClipDurationInSec = {{ $duration }};

function onClickRecordBtn(elem) {
  console.log('onClickRecordBtn:elem=<',elem,'>');
  $( '#wai-recoder-clip-done' ).addClass( 'd-none' );
  
  let timerCounterMax = RECORD_TIME_MS/300 -2; 
  let timerCounter = RECORD_TIME_MS/300 -2; 
  let parent = elem.parentElement;
  console.log('onClickRecordBtn:parent=<',parent,'>');
  let progress = parent.getElementsByClassName('progress-bar')[0];
  console.log('onClickRecordBtn:progress=<',progress,'>');
  progress.style.cssText ='width: 100%;'; 
  let timer = setInterval( function() {
    let percentage = 100*timerCounter/timerCounterMax;
    progress.style.cssText ='width: ' + percentage + '%;'; 
    if(timerCounter-- <= 0) {
      clearInterval(timer);
    }
  },300);
  let root = elem.parentElement.parentElement.parentElement.parentElement;
  console.log('onClickRecordBtn:root=<',root,'>');
  let phoneme = root.getElementsByTagName('h1')[0].textContent;
  console.log('onClickRecordBtn:phoneme=<',phoneme,'>');
  doLearAudio(phoneme);
}
function doLearAudio(phoneme) {
  console.log('doAudioRecord:phoneme=<',phoneme,'>');
  let mediaConstraints = { audio: true};
  navigator.getUserMedia(mediaConstraints, function(stream) {
      onMediaSuccess(stream,phoneme);
    }, onMediaError);
}
function onMediaSuccess(stream,phoneme) {
  let audioCtx = new AudioContext();
  let source = audioCtx.createMediaStreamSource(stream);
  splitPhonemeClips(audioCtx,source,phoneme);
}

function onMediaError(e) {
  console.error('media error e=<', e,'>');
}

</script>

