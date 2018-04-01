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
/*
  let f100 = new AudioFreqDemux(audioCtx,source,dMinDeltaLowFeqWave,function(freqs){
    console.log('f100 freqs=<',freqs,'>');
  },50,500);
//  let f200 = new AudioFreqDemux(audioCtx,source,dMinDeltaLowFeqWave,200,300);
//  let f300 = new AudioFreqDemux(audioCtx,source,dMinDeltaLowFeqWave,300,500);
  let f400 = new AudioFreqDemux(audioCtx,source,dMinDeltaMiddleFeqWave,700);
//  let f500 = new AudioFreqDemux(audioCtx,source,dMinDeltaLowFeqWave,500,700);
//  let f600 = new AudioFreqDemux(audioCtx,source,dMinDeltaLowFeqWave,600,700);
  let f700 = new AudioFreqDemux(audioCtx,source,dMinDeltaMiddleFeqWave,700,1000);
//  let f800 = new AudioFreqDemux(audioCtx,source,dMinDeltaHighFeqWave,800,900);
//  let f900 = new AudioFreqDemux(audioCtx,source,dMinDeltaHighFeqWave,900,1100);
  let fk = new AudioFreqDemux(audioCtx,source,dMinDeltaHighFeqWave,1000,1600);
  let fear = new AudioFreqDemux(audioCtx,source,dMinDeltaHighFeqWave,1600,16384);
*/
}




</script>

