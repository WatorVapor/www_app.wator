<script type="text/javascript">
function onUpdateData(msg) {
  console.log('onUpdateData:msg=<',msg,'>');
}
let AudioContext = window.AudioContext || window.webkitAudioContext;
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
function onMediaSuccess(stream) {
  console.log('onMediaSuccess:stream=<',stream,'>');
}
function onMediaError(e) {
  console.error('media error e=<', e,'>');
}
</script>
