<script type="text/javascript">
//const FilterWindowSize = 8192;
const dMinDeltaRawFeqWave = 0.001;
const dMinDeltaLowFeqWave = 0.16;
const dMinDeltaMiddleFeqWave = 0.04;
const dMinDeltaHighFeqWave = 0.02;

let prevRawAudioBuffer = false;


function isStongWave(wave) {
  //console.log('isStongWave:wave=<',wave,'>');
  let energy = 0.0;
  for(let i = 0;i < wave.length ;i++) {
    let level = Math.abs(wave[i]);
    //console.log('isStongWave:level=<',level,'>');
    energy += level;
  }
  //console.log('isStongWave:energy=<',energy,'>');
  let avarageEnergy = energy/wave.length;
  //console.log('isStongWave:avarageEnergy=<',avarageEnergy,'>');
  if(avarageEnergy > 0.1) {
    return true;
  }
  return false;
}
let filterCtx = new AudioContext();

function onRawAudioData(evt) {
  let audioBuffer = evt.inputBuffer;
  //console.log('onaudioprocess:evt=<',evt,'>');
  //console.log('onaudioprocess:audioBuffer=<',audioBuffer,'>');
  if(prevRawAudioBuffer) {
    let audioCtx = filterCtx;
    //console.log('onaudioprocess:audioCtx=<',audioCtx,'>');
    let frameCount = audioBuffer.length + prevRawAudioBuffer.length;
    let myArrayBuffer = audioCtx.createBuffer(audioBuffer.numberOfChannels, frameCount, audioCtx.sampleRate);
    
    let prevData = prevRawAudioBuffer.getChannelData(0);
    myArrayBuffer.copyToChannel(prevData,0,0);
    let data = audioBuffer.getChannelData(0);
    myArrayBuffer.copyToChannel(data,0,prevData.length);
    //console.log('onaudioprocess:myArrayBuffer=<',myArrayBuffer,'>');
    
    if(isStongWave(myArrayBuffer.getChannelData(0))) {
      let source = audioCtx.createBufferSource();
      let jsProcess = audioCtx.createScriptProcessor(FilterWindowSize, 1, 1);
      source.onended = function(evt) {
        console.log('onaudioprocess:onended evt=<',evt,'>');
        source.disconnect();
        jsProcess.disconnect();
      }
      source.buffer = myArrayBuffer;

      jsProcess.onaudioprocess = function(evt) {
        console.log('onaudioprocess:onaudioprocess evt=<',evt,'>');
      }
      source.connect(jsProcess);
      jsProcess.connect(audioCtx.destination);
      source.start();
    }    
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

