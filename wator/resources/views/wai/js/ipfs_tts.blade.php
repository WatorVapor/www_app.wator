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

let baseDuration = 0.4;

function creatAudioBufferByIPFSClips(tts,cb) {
  console.log('creatAudioBufferByIPFSClips:tts=<',tts,'>');
  if(tts.lang ==='ja') {
    baseDuration = 0.2;
  }
  if(ttsStorageReadyState) {
    if(tts.list.length > 0){
      createClipsAudio(0,tts.list);
    }
  } else {
    ttsCached = tts;
    ttsCB = cb;
  }
}
</script>
