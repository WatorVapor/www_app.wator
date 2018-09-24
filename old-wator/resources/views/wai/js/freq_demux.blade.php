<script type="text/javascript">


let filterCounter = 0;
const FilterWindowSize = 16384;
class AudioFreqDemux {
  constructor(audioCtx,source,delta,cb,freqFrom,freqTo) {
    this.audioCtx = audioCtx;
    this.source = source;
    this.freqFrom = freqFrom;
    this.freqTo = freqTo;
    this.delta = delta;
    this.cb = cb;
    this.sampleRate = this.audioCtx.sampleRate;

    this.offset = filterCounter++;
    this.convolutionalBuffer = [];
    this.createAudioPipe_();
  }
  createAudioPipe_() {
    this.jsProcess = this.audioCtx.createScriptProcessor(FilterWindowSize, 1, 1);
    this.jsProcess.onaudioprocess = this.onData_.bind(this);
    if(this.freqFrom && this.freqTo) {
      this.filter = this.audioCtx.createBiquadFilter();
      this.filter.type = 'bandpass';
      let from = this.freqFrom;
      let to = this.freqTo;
      let geometricMean = Math.sqrt(from * to);
      this.filter.frequency.value = geometricMean;
      this.filter.Q.value = geometricMean / (to - from);
      this.source.connect(this.filter);
      this.filter.connect(this.jsProcess);
    } else {
      this.source.connect(this.jsProcess);
    }
    this.jsProcess.connect(this.audioCtx.destination);
  }  
  onData_(evt){
    //console.log('onData_:evt=<',evt,'>');
    let audioData = evt.inputBuffer.getChannelData(0);
    this.convolutionalBuffer.push(...audioData);
    if(this.convolutionalBuffer.length > FilterWindowSize) {
      let peaks = this.checkPeak2Peak(this.convolutionalBuffer,this.delta);
      let freq = this.calFreq(peaks);
      //console.log('onData_:freq=<',freq,'>');
      this.cb(this.convolutionalBuffer,freq,peaks);
    }
  }
  
  end() {
    if(this.filter) {
      this.filter.disconnect();
    }
    if(this.jsProcess) {
      this.jsProcess.disconnect();
    }
  }



  checkPeak2Peak(wave,dMinDeltaWave) {
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

  calFreq(peaks) {
    let freqs = [];

    for(let i = 1;i < peaks.length;i++) {
      let pk2pk = peaks[i][0] - peaks[i-1][0];
      let index = peaks[i][0];
      let freq = Math.floor(this.sampleRate/(2*pk2pk));
      freqs.push([index,freq,peaks[i][1]]);
    }
    //console.log('calFreq:freqs=<',freqs,'>');
    return freqs;
  }


};





</script>
