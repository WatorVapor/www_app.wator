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
  let source = audioContext.createMediaStreamSource(stream);
  let jsNode = audioContext.createJavaScriptNode(2048, 1, 1);
  jsNode.onaudioprocess = onAudioProcess;
  source.connect(jsNode);
  jsNode.connect(audioCtx.destination);
}

function onAudioProcess(evt) {
  console.log('onAudioProcess:evt=<',evt,'>');
}


</script>
