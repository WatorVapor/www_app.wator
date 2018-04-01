
class AudioFreqDemux {
  constructor(source,delta,freqFrom,freqTo) {
    this.totalBuffer = [];
    this.source = source;
    this.freqFrom = freqFrom;
    this.freqTo = freqTo;
    this.delta = delta;
    this.offset = filterCounter++;
    this.createAudioPipe_();
  }
  onEnd() {
    let peaks = checkPeak2Peak(this.totalBuffer,this.delta);
    let freqs = calFreq(peaks);
    let svg = createWavePolyline(iWaveHeight,this.offset * iWaveHeight,this.totalBuffer,peaks,freqs);
    return svg;
  }
  getWidth() {
    return this.totalBuffer.length;
  }
  createAudioPipe_() {
    let jsProcess = audioCtx.createScriptProcessor(16384, 1, 1);
    jsProcess.onaudioprocess = this.onData_.bind(this);
    if(this.freqFrom && this.freqTo) {
      let filter = audioCtx.createBiquadFilter();
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
    jsProcess.connect(audioCtx.destination);
  }  
  onData_(evt){
    //console.log('onData:evt=<',evt,'>');
    let audioData = evt.inputBuffer.getChannelData(0);
    //console.log('onData:audioData=<',audioData,'>');
    this.totalBuffer.push(...audioData);
  }
};
