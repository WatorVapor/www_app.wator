
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
  doAudioRecord(phoneme);
}
function doAudioRecord(phoneme) {
  console.log('doAudioRecord:phoneme=<',phoneme,'>');
  let mediaConstraints = { audio: true};
  navigator.getUserMedia(mediaConstraints, function(stream) {
      onMediaSuccess(stream,phoneme);
    }, onMediaError);
}
function onMediaSuccess(stream,phoneme) {
  let mr = new MediaRecorder(stream);
  mr.mimeType = 'audio/webm';
  let chunks4analyze = [];
  mr.ondataavailable = function (e) {
    chunks4analyze.push(e.data);
  }
  mr.onerror = function (e) {
    console.log('error:e=<',e,'>');
  }
  mr.onstart = function (e) {
    console.log('onstart:e=<',e,'>');
  }
  mr.onstop = function (e) {
    console.log('onstop:e=<',e,'>');
    console.log('onstop:chunks4analyze=<',chunks4analyze,'>');
    analyzeBlobWebm(chunks4analyze);
  }
  mr.start(RECORD_INTERVAL_MS);
  setTimeout(function(){
    mr.stop();
  },RECORD_TIME_MS);
}


function onMediaError(e) {
  console.error('media error e=<', e,'>');
}

let audioCtx = new AudioContext();

function analyzeBlobWebm(chunks) {
  console.log('analyzeBlobWebm chunks=<',chunks,'>');
  const blob = new Blob(chunks, { type: 'audio/webm' });
  /*
  let urlBlob = window.URL.createObjectURL(blob);
  let audioElem = document.getElementById('wai-recoder-audio-train');
  audioElem.src = urlBlob;
  console.log('analyzeBlobWebm audioElem=<',audioElem,'>');
  let source = audioCtx.createMediaElementSource(audioElem);
  console.log('analyzeBlobWebm source=<',source,'>');
  */
  let source = audioCtx.createBufferSource();
  let reader = new FileReader();
  reader.onload = function() {
    audioCtx.decodeAudioData(reader.result, function(decodedData) {
      console.log('analyzeBlobWebm decodedData=<',decodedData,'>');
      source.buffer = decodedData;
      splitPhonemeClips(source);
    });
  };
  reader.readAsArrayBuffer(blob);
}
</script>

