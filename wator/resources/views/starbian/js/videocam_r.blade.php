<script type="text/javascript">


let keyChannel = false;

navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || window.navigator.mozGetUserMedia;
window.URL = window.URL || window.webkitURL;
    

function onNotifyReady() {
  let params = location.pathname.split('/');
  let key = params[params.length -1];
  console.log('onNotifyReady:key=<',key,'>');
  if(key) {
    keyChannel = key;
    sendMsg(key,{start:true});
    startCamera();
  }
  
}

function startCamera() {
  let option = {video: true, audio: true}
  navigator.getUserMedia(option, onStreamGot,onStreamError)
}

function onStreamGot(stream) {
  console.log('onStreamGot:stream=<',stream,'>');
}

function onStreamError(error) {
  console.log('onStreamError:error=<',error,'>');
}

</script>
