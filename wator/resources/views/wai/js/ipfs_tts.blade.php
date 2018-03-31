<script type="text/javascript">
let ttsStorage = new IpfsStorage(); 
let ttsStorageReadyState = false;
let ttsCached = false;
let ttsCB = false;

ttsStorage.onReady = function(evt) {
  console.log('ttsStorage.onReady:evt=<',evt,'>');
  ttsStorageReadyState = true;
  if(ttsCached) {
    setTimeout(function(){
      creatAudioBufferByIPFSClips(ttsCached,ttsCB);
    },1);
  }
}

let baseDuration = 0.2;

function creatAudioBufferByIPFSClips(tts,cb) {
  console.log('creatAudioBufferByIPFSClips:tts=<',tts,'>');
  if(ttsStorageReadyState) {
    if(tts.length > 0){
      createClipsAudio(0,tts);
    }
  } else {
    ttsCached = tts;
    ttsCB = cb;
  }
}
</script>
