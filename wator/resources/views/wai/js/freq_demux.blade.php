<script type="text/javascript">


let filterCounter = 0;
class AudioFreqDemux {
  constructor(audioCtx,source,delta,freqFrom,freqTo) {
    this.audioCtx = audioCtx;
    this.source = source;
    this.freqFrom = freqFrom;
    this.freqTo = freqTo;
    this.delta = delta;

    this.offset = filterCounter++;
    this.totalBuffer = [];
    this.createAudioPipe_();
  }
  createAudioPipe_() {
    let jsProcess = this.audioCtx.createScriptProcessor(8192, 1, 1);
    jsProcess.onaudioprocess = this.onData_.bind(this);
    if(this.freqFrom && this.freqTo) {
      let filter = this.audioCtx.createBiquadFilter();
      filter.type = 'bandpass';
      let from = this.freqFrom;
      let to = this.freqTo;
      let geometricMean = Math.sqrt(from * to);
      filter.frequency.value = geometricMean;
      filter.Q.value = geometricMean / (to - from);
      this.source.connect(filter);
      filter.connect(jsProcess);
    } else {
      this.source.connect(jsProcess);
    }
    jsProcess.connect(this.audioCtx.destination);
  }  
  onData_(evt){
    //console.log('onData_:evt=<',evt,'>');
    let audioData = evt.inputBuffer.getChannelData(0);
    //console.log('onData:audioData=<',audioData,'>');
    this.totalBuffer.push(...audioData);
  }
};



function checkPeak2Peak(wave,dMinDeltaWave) {
  let peakT = [];
  let peakB = [];
  
  let peaks = [];
  let peakPrev = 0.0;
  
  for(let i = 1;i < wave.length -1;i++) {
    if(wave[i] >= wave[i-1] && wave[i] >= wave[i+1]) {
      let delta = Math.abs(peakPrev - wave[i]);
      if(delta > dMinDeltaWave){
        peakT.push(i);
        peaks.push([i,wave[i]]);
        peakPrev = wave[i];
      }
    }
    if(wave[i] <= wave[i-1] && wave[i] <= wave[i+1]) {
      let delta = Math.abs(peakPrev - wave[i]);
      if(delta > dMinDeltaWave){
        peakB.push(i); 
        peaks.push([i,wave[i]]);
        peakPrev = wave[i];
      }
    }
  }
  //console.log('checkPeak2Peak:peakT=<',peakT,'>');
  //console.log('checkPeak2Peak:peakB=<',peakB,'>');
  return peaks;
}

function calFreq(peaks) {
  let freqs = [];
  
  for(let i = 1;i < peaks.length;i++) {
    let freq = peaks[i][0] - peaks[i-1][0];
    let index = peaks[i][0];
    freqs.push([index,freq,peaks[i][1]]);
  }
  //console.log('calFreq:freqs=<',freqs,'>');
  return freqs;
}


</script>
