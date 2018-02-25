<script type="text/javascript">
function clipPhoneme(audioData)  
  let buffer = audioCtx.createBuffer(1, ClipDurationInSec *sample , sample);
  let audioData = buffer.getChannelData(0);
  let startClipBuffer = waveEnergyMaxIndex - clipWindowSize;
  for(var i = 0; i < audioData.length; i++) {
      audioData[i] = data[i + startClipBuffer];
  }
  let nodeSrc = audioCtx.createBufferSource();
  nodeSrc.buffer = buffer;
  let dest = audioCtx.createMediaStreamDestination();
  let mediaRecorder = new MediaRecorder(dest.stream);
  mediaRecorder.mimeType = 'audio/webm';
  nodeSrc.connect(audioCtx.destination);
  console.log('showWaveChart nodeSrc=<',nodeSrc,'>');
  let chunks = [];
  mediaRecorder.ondataavailable = function(evt) {
    chunks.push(evt.data);
    console.log('showWaveChart evt=<',evt,'>');
  };
  mediaRecorder.onstop = function(evt) {
    let blobClip = new Blob(chunks, { 'type' : 'audio/webm' });
    console.log('showWaveChart blobClip=<',blobClip,'>');
    let urlBlob = window.URL.createObjectURL(blobClip);
    console.log('doClipWave urlBlob=<',urlBlob,'>');
    let audioElem = document.getElementById('wai-recoder-audio-train');
    audioElem.src = urlBlob;
  };
  nodeSrc.connect(dest);
  mediaRecorder.start();
  nodeSrc.start(0);
  setTimeout(function(){
    mediaRecorder.stop();
  },1000);
}
</script>
