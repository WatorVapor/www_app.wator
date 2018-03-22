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


function onMediaSuccess(stream) {
  console.log('onMediaSuccess:stream=<',stream,'>');
  let source = audioCtx.createMediaStreamSource(stream);
  let jsProcess = audioCtx.createScriptProcessor(2048, 1, 1);
  jsProcess.onaudioprocess = onAudioProcess;
  source.connect(jsProcess);
  jsProcess.connect(audioCtx.destination);
}



let canvas = document.getElementById('wai-recognition-wave');
let ctx = canvas.getContext('2d');


function onAudioProcess(evt) {
  //console.log('onAudioProcess:evt=<',evt,'>');
  let input = evt.inputBuffer.getChannelData(0);
  console.log('onAudioProcess:input=<',input,'>');
  let width = canvas.width;
  let height = canvas.height;

  console.log('onAudioProcess:width=<',width,'>');
  console.log('onAudioProcess:height=<',height,'>');
}


</script>
