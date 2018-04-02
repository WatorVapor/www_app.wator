<script type="text/javascript">


const FilterWindowSize = 8192;

const dMinDeltaRawFeqWave = 0.001;
const dMinDeltaLowFeqWave = 0.16;
const dMinDeltaMiddleFeqWave = 0.04;
const dMinDeltaHighFeqWave = 0.02;


function splitPhonemeClips(audioCtx,source) {
  console.log('splitPhonemeClips source=<',source,'>');
  
  let jsProcess = audioCtx.createScriptProcessor(FilterWindowSize, 1, 1);
  jsProcess.onaudioprocess = function(evt) {
    let audioBuffer = evt.inputBuffer
    console.log('onaudioprocess:audioBuffer=<',audioBuffer,'>');
  };
  source.connect(jsProcess);

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

