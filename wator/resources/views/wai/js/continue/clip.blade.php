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



const dMinDeltaRawFeqWave = 0.001;
const dMinDeltaLowFeqWave = 0.08;
const dMinDeltaMiddleFeqWave = 0.02;
const dMinDeltaHighFeqWave = 0.01;


function splitPhonemeClips(source) {
  console.log('splitPhonemeClips source=<',source,'>');
  let fraw = new AudioFreqDemux (source,dMinDeltaRawFeqWave);
/*
  let f100 = new AudioFreqDemux(source,dMinDeltaLowFeqWave,100,400);
//  let f200 = new AudioFreqDemux(source,dMinDeltaLowFeqWave,200,300);
//  let f300 = new AudioFreqDemux(source,dMinDeltaLowFeqWave,300,500);
  let f400 = new AudioFreqDemux(source,dMinDeltaMiddleFeqWave,700);
//  let f500 = new AudioFreqDemux(source,dMinDeltaLowFeqWave,500,700);
//  let f600 = new AudioFreqDemux(source,dMinDeltaLowFeqWave,600,700);
  let f700 = new AudioFreqDemux(source,dMinDeltaMiddleFeqWave,700,1000);
//  let f800 = new AudioFreqDemux(source,dMinDeltaHighFeqWave,800,900);
//  let f900 = new AudioFreqDemux(source,dMinDeltaHighFeqWave,900,1100);
  let fk = new AudioFreqDemux(source,dMinDeltaHighFeqWave,1000,1600);
  let fear = new AudioFreqDemux(source,dMinDeltaHighFeqWave,1600,16384);
*/

}




</script>

