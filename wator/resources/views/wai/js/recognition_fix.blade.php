<script type="text/javascript">
function onUpdateData(msg) {
  console.log('onUpdateData:msg=<',msg,'>');
}
const AudioContext = window.AudioContext || window.webkitAudioContext;
let audioCtx = new AudioContext();
function onClickRecognition(elem) {
  console.log('onClickRecordBtn:elem=<',elem,'>');
  $( '#wai-recoder-clip-done' ).addClass( 'd-none' );
  doAudioRecord();
}
function doAudioRecord() {
  let mediaConstraints = { audio: true};
  navigator.getUserMedia(mediaConstraints, function(stream) {
      onMediaSuccess(stream);
    }, onMediaError);
}
function onMediaError(e) {
  console.error('media error e=<', e,'>');
}


const RECORD_TIME_MS = 3000;
const dMinDeltaRawFeqWave = 0.001;
const dMinDeltaLowFeqWave = 0.08;
const dMinDeltaMiddleFeqWave = 0.02;
const dMinDeltaHighFeqWave = 0.01;
const iWaveHeight = 200;


let filterCounter = 0;
class FilterAudioPipe {
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


function onMediaSuccess(stream) {
  console.log('onMediaSuccess:stream=<',stream,'>');
  let source = audioCtx.createMediaStreamSource(stream);
 
  let fraw = new FilterAudioPipe(source,dMinDeltaRawFeqWave);
  
  let f100 = new FilterAudioPipe(source,dMinDeltaLowFeqWave,100,400);
//  let f200 = new FilterAudioPipe(source,dMinDeltaLowFeqWave,200,300);
//  let f300 = new FilterAudioPipe(source,dMinDeltaLowFeqWave,300,500);
  let f400 = new FilterAudioPipe(source,dMinDeltaMiddleFeqWave,700);
//  let f500 = new FilterAudioPipe(source,dMinDeltaLowFeqWave,500,700);
//  let f600 = new FilterAudioPipe(source,dMinDeltaLowFeqWave,600,700);
  let f700 = new FilterAudioPipe(source,dMinDeltaMiddleFeqWave,700,1000);
//  let f800 = new FilterAudioPipe(source,dMinDeltaHighFeqWave,800,900);
//  let f900 = new FilterAudioPipe(source,dMinDeltaHighFeqWave,900,1100);
  let fk = new FilterAudioPipe(source,dMinDeltaHighFeqWave,1000,1600);

  let fear = new FilterAudioPipe(source,dMinDeltaHighFeqWave,1600,16384);

  setTimeout(function(){
    source.disconnect();
  },RECORD_TIME_MS);
  
  
  setTimeout(function(){
    let svg = '';
    svg += fraw.onEnd();
    svg += f100.onEnd();
    //svg += f200.onEnd();
    //svg += f300.onEnd();
    svg += f400.onEnd();
    //svg += f500.onEnd();
    //svg += f600.onEnd();
    svg += f700.onEnd();
    //svg += f800.onEnd();
    //svg += f900.onEnd();
    svg += fk.onEnd();
    svg += fear.onEnd();
    console.log('onMediaSuccess:svg.length=<',svg.length,'>');
    saveAllSVG(iWaveHeight,6,svg,fraw.getWidth());
  },RECORD_TIME_MS + 1000);
}

function createAudioPipe(source,onData,freqL,freqH) {
  let jsProcess = audioCtx.createScriptProcessor(16384, 1, 1);
  jsProcess.onaudioprocess = onData;
  if(freqL && freqH) {
    filter = audioCtx.createBiquadFilter();
    filter.type = 'bandpass';
    let from = freqL;
    let to = freqH;
    let geometricMean = Math.sqrt(from * to);
    filter.frequency.value = geometricMean;
    filter.Q.value = geometricMean / (to - from);
    source.connect(filter);
    filter.connect(jsProcess);
  } else {
    source.connect(jsProcess);
  }
  jsProcess.connect(audioCtx.destination);
}

let totalRawBuffer = [];
function onRawAudioProcess(evt) {
  //console.log('onRawAudioProcess:evt=<',evt,'>');
  let audioData = evt.inputBuffer.getChannelData(0);
  //console.log('onRawAudioProcess:audioData=<',audioData,'>');
  totalRawBuffer.push(...audioData);
}

let totalBuffer = [];
function onAudioProcess(evt) {
  //console.log('onAudioProcess:evt=<',evt,'>');
  let audioData = evt.inputBuffer.getChannelData(0);
  //console.log('onAudioProcess:audioData=<',audioData,'>');
  totalBuffer.push(...audioData);
}

let totalBufferMiddle = [];
function onAudioProcessMiddle(evt) {
  //console.log('onAudioProcessMiddle:evt=<',evt,'>');
  let audioData = evt.inputBuffer.getChannelData(0);
  //console.log('onAudioProcessMiddle:audioData=<',audioData,'>');
  totalBufferMiddle.push(...audioData);
}

let totalBufferHigh = [];
function onAudioProcessHigh(evt) {
  //console.log('onAudioProcessHigh:evt=<',evt,'>');
  let audioData = evt.inputBuffer.getChannelData(0);
  //console.log('onAudioProcessHigh:audioData=<',audioData,'>');
  totalBufferHigh.push(...audioData);
}


let svg = false;
let svgMiddle = false;
let svgHigh = false;
let svgRaw = false;

function onAudioRawTotalClipSuccess() {
  //console.log('onAudioHighTotalClipSuccess:totalRawBuffer=<',totalRawBuffer,'>');
  let peaks = checkPeak2Peak(totalRawBuffer,dMinDeltaRawFeqWave);
  let freqs = calFreq(peaks);
  svgRaw = createWavePolyline(200,0,totalRawBuffer,peaks,freqs);
  if(svg && svgMiddle && svgHigh && svgRaw) {
    saveAllSVG(200,4,svgRaw + svg + svgMiddle + svgHigh);
  }
  totalRawBuffer = [];
}


function onAudioTotalClipSuccess() {
  //console.log('onAudioTotalClipSuccess:totalBuffer=<',totalBuffer,'>');
  let peaks = checkPeak2Peak(totalBuffer,dMinDeltaLowFeqWave);
  let freqs = calFreq(peaks);
  svg = createWavePolyline(200,200,totalBuffer,peaks,freqs);
  if(svg && svgHigh && svgRaw) {
    saveAllSVG(200,4,svgRaw + svg + svgMiddle + svgHigh);
  }
  totalBuffer = [];
}

function onAudioMiddleTotalClipSuccess() {
  //console.log('onAudioMiddleTotalClipSuccess:totalBuffer=<',totalBuffer,'>');
  let peaks = checkPeak2Peak(totalBufferMiddle,dMinDeltaMiddleFeqWave);
  let freqs = calFreq(peaks);
  svgMiddle = createWavePolyline(200,400,totalBufferMiddle,peaks,freqs);
  if(svg && svgMiddle && svgHigh && svgRaw) {
    saveAllSVG(200,4,svgRaw + svg + svgMiddle + svgHigh);
  }
  totalBufferMiddle = [];
}


function onAudioHighTotalClipSuccess() {
  //console.log('onAudioHighTotalClipSuccess:totalBuffer=<',totalBuffer,'>');
  let peaks = checkPeak2Peak(totalBufferHigh,dMinDeltaHighFeqWave);
  let freqs = calFreq(peaks);
  svgHigh = createWavePolyline(200,600,totalBufferHigh,peaks,freqs);
  if(svg && svgMiddle && svgHigh && svgRaw) {
    saveAllSVG(200,4,svgRaw + svg + svgMiddle + svgHigh);
  }
  totalBufferHigh = [];
}





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
