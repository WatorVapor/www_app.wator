<script type="text/javascript">
let gClipChunks = [];
function clipPhoneme(data,waveEnergyMax,waveEnergyMaxIndex,sample) {
  console.log('clipPhoneme waveEnergyMax=<',waveEnergyMax,'>');
  console.log('clipPhoneme waveEnergyMaxIndex=<',waveEnergyMaxIndex,'>');
  let clipWindowSize = ClipDurationInSec * sample;
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
  console.log('clipPhoneme nodeSrc=<',nodeSrc,'>');
  mediaRecorder.ondataavailable = function(evt) {
    gClipChunks.push(evt.data);
    console.log('clipPhoneme evt=<',evt,'>');
  };
  mediaRecorder.onstop = function(evt) {
    let blobClip = new Blob(gClipChunks, { 'type' : 'audio/webm' });
    console.log('clipPhoneme blobClip=<',blobClip,'>');
    let urlBlob = window.URL.createObjectURL(blobClip);
    console.log('clipPhoneme urlBlob=<',urlBlob,'>');
    let audioElem = document.getElementById('wai-recoder-audio-train');
    audioElem.src = urlBlob;
    $( '#wai-recoder-clip-done' ).removeClass( 'd-none' );
  };
  nodeSrc.connect(dest);
  mediaRecorder.start();
  nodeSrc.start(0);
  setTimeout(function(){
    mediaRecorder.stop();
  },1000);
}




function splitPhonemeClips(source) {
  console.log('splitPhonemeClips source=<',source,'>');

let fraw = new FilterAudioPipe(source,dMinDeltaRawFeqWave);
  
  let f100 = new FilterAudioPipe(source,dMinDeltaLowFeqWave,100,400);
//  let f200 = new FilterAudioPipe(source,dMinDeltaLowFeqWave,200,300);
//  let f300 = new FilterAudioPipe(source,dMinDeltaLowFeqWave,300,500);
  let f400 = new FilterAudioPipe(source,dMinDeltaMiddleFeqWave,700);
//  let f500 = new FilterAudioPipe(source,dMinDeltaLowFeqWave,500,700);
//  let f600 = new FilterAudioPipe(source,dMinDeltaLowFeqWave,600,700);
  let f700 = new FilterAudioPipe(source,dMinDeltaMiddleFeqWave,700,1000);
//  let f800 = new FilterAudioPipe(source,dMinDeltaHighFeqWave,800,900);
//  let f900 = new FilterAudioPipe(source,dMinDeltaHighFeqWave,900,1100);
  let fk = new FilterAudioPipe(source,dMinDeltaHighFeqWave,1000,1600);
  let fear = new FilterAudioPipe(source,dMinDeltaHighFeqWave,1600,16384);

}




</script>

