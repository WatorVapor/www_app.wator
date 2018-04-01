<script type="text/javascript">


let filterCounter = 0;
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
    let self = this;
    this.rcvData = false;
    let timer = setInterval(function(){
      if(self.rcvData == false) {
        clearInterval(timer);
        self.onEnd();
      }
      self.rcvData = false;
    },500);
  }  
  onData_(evt){
    this.rcvData = true;
    //console.log('onData:evt=<',evt,'>');
    let audioData = evt.inputBuffer.getChannelData(0);
    console.log('onData:audioData=<',audioData,'>');
    this.totalBuffer.push(...audioData);
  }
  onEndedCheck_(evt){
    console.log('onEnded_:evt=<',evt,'>');
  }
};


function saveAllSVG(height,row,svgRows,width) {
  let svg = '<svg width="';
  svg += width ;
  svg += '" height="';
  svg += height * row;
  svg += '" xmlns="http://www.w3.org/2000/svg">';
  svg += '\n';
  svg += svgRows;
  svg += '</svg>';
  let blob = new Blob([svg], {type: "image/svg+xml;charset=utf-8"});
  let urlBlob = window.URL.createObjectURL(blob);
  console.log('createWaveSVG:urlBlob=<',urlBlob,'>');
  let img = document.getElementById('wai-recognition-wave');
  img.src = urlBlob;
  var a = document.createElement('a');
  a.href = urlBlob;
  a.download = 'wai.recog_fix.svg';
  a.click();
  svg = false;
  svgHigh = false;
  svgRaw = false;
}
function createWavePolyline(height,offsetY,wave,peaks,freqs) {
  let width = wave.length;
  //console.log('createWavePolyline:wave=<',wave,'>');
  let peak = height/2;
  
  svg += '<polyline points="';
  for(let i = 0;i < wave.length ;i++) {
    let y = offsetY + peak - wave[i] * peak;
    let x = i;
    svg +=  ' ' + x  + ',' + y;
  }
  svg += '"';
  svg += '\n';
  svg += ' fill="none" stroke="red" stroke-width="1" />';
  svg += '<polyline points="';
  for(let i = 0;i < peaks.length ;i++) {
    let y = offsetY + peak - peaks[i][1] * peak;
    let x = peaks[i][0];
    svg +=  ' ' + x  + ',' + y;
  }
  svg += '"';
  svg += '\n';
  svg += ' fill="none" stroke="green" stroke-width="1" />';
/*
  for(let i = 0;i < peaks.length ;i++) {
    let y = peak - peaks[i][1] * peak;
    let x = peaks[i][0];
    svg += '<text font-size="1" x="';
    svg += x;
    svg += '" y="';
    svg += offsetY + y;
    svg += '">';
    svg += peaks[i][0] %100;
    svg +=  '</text>';
  }
*/
  let counter = 0;
  for(let i = 0;i < freqs.length ;i++) {
    let y = peak - freqs[i][2] * peak;
    if(y < 30) {
      y += 30;
    }
    if(y > height -30) {
      y -= 30;
    }
    y += offsetY;
    let x = freqs[i][0];
    svg += '<text font-size="12" x="';
    svg += x;
    svg += '" y="';
    svg += y;
    svg += '">';
    svg += freqs[i][1];
    svg +=  '</text>';
    svg += '\n';
 }
  
  
  let centerY = peak+offsetY;
  svg += '<polyline points="';
  svg += ' 0,' + centerY + ' ';
  svg += width +',' + centerY + ' ';
  svg += '"';
  svg += '\n';
  svg += ' fill="none" stroke="blue" stroke-width="1" />';
  svg += '\n';
  return svg;
}
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
