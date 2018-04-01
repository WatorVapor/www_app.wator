<script type="text/javascript">

const dMinDeltaRawFeqWave = 0.001;
const dMinDeltaLowFeqWave = 0.08;
const dMinDeltaMiddleFeqWave = 0.02;
const dMinDeltaHighFeqWave = 0.01;


function splitPhonemeClips(audioCtx,source) {
  console.log('splitPhonemeClips source=<',source,'>');
  let fRaw = new AudioFreqDemux (audioCtx,source,dMinDeltaRawFeqWave,function(freqs){
    //console.log('fRaw freqs=<',freqs,'>');
  });
  let fLow = new AudioFreqDemux(audioCtx,source,dMinDeltaLowFeqWave,function(freqs){
    if(freqs.length >0) {
      console.log('fLow freqs=<',freqs,'>');
    }
  },50,500);
  let fMiddle = new AudioFreqDemux(audioCtx,source,dMinDeltaMiddleFeqWave,function(freqs){
    if(freqs.length >100) {
      console.log('fMiddle freqs=<',freqs,'>');
    }
  },500,1000);
  let fHigh = new AudioFreqDemux(audioCtx,source,dMinDeltaHighFeqWave,function(freqs){
    if(freqs.length >100) {
      console.log('fHigh freqs=<',freqs,'>');
    }
  },1000,1600);
}




</script>

