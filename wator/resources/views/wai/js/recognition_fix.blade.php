<script type="text/javascript">
function onUpdateData(msg) {
  console.log('onUpdateData:msg=<',msg,'>');
}
const AudioContext = window.AudioContext || window.webkitAudioContext;
let audioCtx = new AudioContext();
function onClickRecognition(elem) {
  console.log('onClickRecordBtn:elem=<',elem,'>');
  $( '#wai-recoder-clip-done' ).addClass( 'd-none' );
  doAudioRecord();
}
function doAudioRecord() {
  let mediaConstraints = { audio: true};
  navigator.getUserMedia(mediaConstraints, function(stream) {
      onMediaSuccess(stream);
    }, onMediaError);
}
function onMediaError(e) {
  console.error('media error e=<', e,'>');
}


const RECORD_TIME_MS = 1500;


function onMediaSuccess(stream) {
  console.log('onMediaSuccess:stream=<',stream,'>');
  let source = audioCtx.createMediaStreamSource(stream);
  let filter = audioCtx.createBiquadFilter();
  filter.type = 'lowpass';
  filter.frequency.value = 1024;
  
  let jsProcess = audioCtx.createScriptProcessor(16384, 1, 1);
  jsProcess.onaudioprocess = onAudioProcess;
  source.connect(filter);
  filter.connect(jsProcess);
  jsProcess.connect(audioCtx.destination);
  setTimeout(function(){
    jsProcess.disconnect();
  },RECORD_TIME_MS);
  
  setTimeout(function(){
    onAudioTotalClipSuccess();
  },RECORD_TIME_MS + 1000);
}

let totalBuffer = [];
function onAudioProcess(evt) {
  //console.log('onAudioProcess:evt=<',evt,'>');
  let audioData = evt.inputBuffer.getChannelData(0);
  //console.log('onAudioProcess:audioData=<',audioData,'>');
  totalBuffer.push(...audioData);
}

function onAudioTotalClipSuccess() {
  //console.log('onAudioTotalClipSuccess:totalBuffer=<',totalBuffer,'>');
  createWaveSVG(totalBuffer);
}

function createWaveSVG(wave) {
  //console.log('createWaveSVG:wave=<',wave,'>');
  let width = wave.length;
  let height = width * 0.2;
  console.log('createWaveSVG:width=<',width,'>');
  console.log('createWaveSVG:height=<',height,'>');
  let svg = '<svg width="';
  svg += width;
  svg += '" height="';
  svg += height;
  svg += '" xmlns="http://www.w3.org/2000/svg">';
  svg += '\n';
  svg += '<polyline points="';
  svg += '"';
  svg += 'fill="none" stroke="navy" stroke-width="1" />';
  svg += '\n';
  svg += '</svg>';
  console.log('createWaveSVG:svg=<',svg,'>');
}

</script>
