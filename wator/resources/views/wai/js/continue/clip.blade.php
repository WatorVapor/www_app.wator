<script type="text/javascript">

const dMinDeltaRawFeqWave = 0.001;
const dMinDeltaLowFeqWave = 0.16;
const dMinDeltaMiddleFeqWave = 0.04;
const dMinDeltaHighFeqWave = 0.02;


function splitPhonemeClips(audioCtx,source) {
  console.log('splitPhonemeClips source=<',source,'>');
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
  
}




</script>

