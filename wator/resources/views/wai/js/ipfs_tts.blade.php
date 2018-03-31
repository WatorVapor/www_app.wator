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
ttsStorage.onStorage = function(clipData) {
  //console.log('ttsStorage.onStorage:clipData=<',clipData,'>');
  onRecieveClipData(clipData);
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

let gTTS = false;
let gIndex = false;
function createClipsAudio(index,tts) {
  let clip = tts[index];
  console.log('createClipsAudio:clip=<',clip,'>');
  let fetchClip = {tts:{download:clip}};
  console.log('createClipsAudio:fetchClip=<',fetchClip,'>');
  gTTS = tts;
  gIndex = index;
  ttsStorage.get(fetchClip); 
}


let totalAudioBuffer = [];
let totalDuration = 0;

function onRecieveClipData(file) {
  //console.log('onRecieveClipData:: file=<',file,'>');
  let encodedData = new Uint8Array(file);
  //console.log('onRecieveClipData:: encodedData=<',encodedData,'>');
  //let encodedData = new ArrayBuffer(file);
  //console.log('onRecieveClipData:: encodedData=<',encodedData,'>');
  audioCtx.decodeAudioData(encodedData.buffer, function(decodedData) {
    //console.log('createClipsElement decodedData=<',decodedData,'>');
    totalAudioBuffer.push(decodedData);
    if(decodedData.duration > baseDuration) {
      totalDuration += baseDuration;
    } else {
      totalDuration += decodedData.duration;
    }
    if(gTTS.length > gIndex +1) {
      createClipsAudio(gIndex +1,gTTS)
    } else {
      createLongClip();
    }
  });    
}


</script>
