<script type="text/javascript">

const dMinDeltaRawFeqWave = 0.001;
const dMinDeltaLowFeqWave = 0.08;
const dMinDeltaMiddleFeqWave = 0.02;
const dMinDeltaHighFeqWave = 0.01;


function splitPhonemeClips(audioCtx,source) {
  console.log('splitPhonemeClips source=<',source,'>');
  let fraw = new AudioFreqDemux (audioCtx,source,dMinDeltaRawFeqWave,function(freqs){
    //console.log('fraw freqs=<',freqs,'>');
  });
  let flow = new AudioFreqDemux(audioCtx,source,dMinDeltaLowFeqWave,function(freqs){
    console.log('flow freqs=<',freqs,'>');
  },50,500);
  let fmiddle = new AudioFreqDemux(audioCtx,source,dMinDeltaMiddleFeqWave,function(freqs){
    console.log('fmiddle freqs=<',freqs,'>');
  },500,1000);
  let fHigh = new AudioFreqDemux(audioCtx,source,dMinDeltaHighFeqWave,function(freqs){
    console.log('fHigh freqs=<',freqs,'>');
  },1000,1600);
}




</script>

