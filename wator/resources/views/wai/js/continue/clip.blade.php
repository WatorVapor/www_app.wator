<script type="text/javascript">
//const FilterWindowSize = 8192;
const dMinDeltaRawFeqWave = 0.001;
const dMinDeltaLowFeqWave = 0.16;
const dMinDeltaMiddleFeqWave = 0.04;
const dMinDeltaHighFeqWave = 0.02;

let prevRawAudioBuffer = false;

function onRawAudioData(evt) {
  let audioBuffer = evt.inputBuffer;
  console.log('onaudioprocess:evt=<',evt,'>');
  console.log('onaudioprocess:audioBuffer=<',audioBuffer,'>');
  if(prevRawAudioBuffer) {
    let audioCtx = evt.target.context;
    console.log('onaudioprocess:audioCtx=<',audioCtx,'>');
    let frameCount = audioBuffer.length + prevRawAudioBuffer.length;
    let myArrayBuffer = audioCtx.createBuffer(audioBuffer.channels, frameCount, audioCtx.sampleRate);
    console.log('onaudioprocess:myArrayBuffer=<',myArrayBuffer,'>');
  }
  prevRawAudioBuffer = audioBuffer;
}


function splitPhonemeClips(audioCtx,source) {
  console.log('splitPhonemeClips source=<',source,'>');
  
  let jsProcess = audioCtx.createScriptProcessor(FilterWindowSize, 1, 1);
  jsProcess.onaudioprocess = onRawAudioData;
  source.connect(jsProcess);
  jsProcess.connect(audioCtx.destination);

/*
  let fRaw = new AudioFreqDemux (audioCtx,source,dMinDeltaRawFeqWave,function(freqs){
    //console.log('fRaw freqs=<',freqs,'>');
  });
  
  let fLow = new AudioFreqDemux(audioCtx,source,dMinDeltaLowFeqWave,function(freqs){
    if(freqs.length > 5) {
      console.log('fLow freqs=<',freqs,'>');
    }
  },50,500);
  
  let fMiddle = new AudioFreqDemux(audioCtx,source,dMinDeltaMiddleFeqWave,function(freqs){
    if(freqs.length > 5) {
      console.log('fMiddle freqs=<',freqs,'>');
    }
  },500,1000);
  
  let fHigh = new AudioFreqDemux(audioCtx,source,dMinDeltaHighFeqWave,function(freqs){
    if(freqs.length > 5) {
      console.log('fHigh freqs=<',freqs,'>');
    }
  },1000,1600);
  */
  
}



</script>

