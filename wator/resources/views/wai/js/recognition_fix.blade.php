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


const RECORD_TIME_MS = 2000;


function onMediaSuccess(stream) {
  console.log('onMediaSuccess:stream=<',stream,'>');
  let source = audioCtx.createMediaStreamSource(stream);
  
  let jsProcessRaw = audioCtx.createScriptProcessor(16384, 1, 1);
  jsProcessRaw.onaudioprocess = onRawAudioProcess;
  source.connect(jsProcessRaw);
  jsProcessRaw.connect(audioCtx.destination);

  let filter = audioCtx.createBiquadFilter();
  filter.type = 'bandpass';
  let from = 100;
  let to = 500;
  let geometricMean = Math.sqrt(from * to);
  filter.frequency.value = geometricMean;
  filter.Q.value = geometricMean / (to - from);
  
  let jsProcess = audioCtx.createScriptProcessor(16384, 1, 1);
  jsProcess.onaudioprocess = onAudioProcess;
  source.connect(filter);
  filter.connect(jsProcess);
  jsProcess.connect(audioCtx.destination);


  let filterHigh = audioCtx.createBiquadFilter();
  filterHigh.type = 'bandpass';
  let fromHigh = 400;
  let toHigh = 1600;
  let geometricMeanHigh = Math.sqrt(fromHigh * toHigh);
  filterHigh.frequency.value = geometricMeanHigh;
  filterHigh.Q.value = geometricMeanHigh / (toHigh - fromHigh);
  
  let jsProcessHigh = audioCtx.createScriptProcessor(16384, 1, 1);
  jsProcessHigh.onaudioprocess = onAudioProcessHigh;
  source.connect(filterHigh);
  filterHigh.connect(jsProcessHigh);
  jsProcessHigh.connect(audioCtx.destination);

  
  setTimeout(function(){
    source.disconnect();
  },RECORD_TIME_MS);
  
  
  setTimeout(function(){
    onAudioTotalClipSuccess();
    onAudioHighTotalClipSuccess();
    onAudioRawTotalClipSuccess();
  },RECORD_TIME_MS + 1000);
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

let totalBufferHigh = [];
function onAudioProcessHigh(evt) {
  //console.log('onAudioProcessHigh:evt=<',evt,'>');
  let audioData = evt.inputBuffer.getChannelData(0);
  //console.log('onAudioProcessHigh:audioData=<',audioData,'>');
  totalBufferHigh.push(...audioData);
}

let svg = false;
let svgHigh = false;
let svgRaw = false;

function onAudioTotalClipSuccess() {
  //console.log('onAudioTotalClipSuccess:totalBuffer=<',totalBuffer,'>');
  let peaks = checkPeak2Peak(totalBuffer);
  let freqs = calFreq(peaks);
  svg = createWavePolyline(200,200,totalBuffer,peaks,freqs);
  if(svg && svgHigh && svgRaw) {
    saveAllSVG(200,3,svgRaw + svg + svgHigh);
  }
  totalBuffer = [];
}


function onAudioHighTotalClipSuccess() {
  //console.log('onAudioHighTotalClipSuccess:totalBuffer=<',totalBuffer,'>');
  let peaks = checkPeak2Peak(totalBufferHigh);
  let freqs = calFreq(peaks);
  svgHigh = createWavePolyline(200,400,totalBufferHigh,peaks,freqs);
  if(svg && svgHigh && svgRaw) {
    saveAllSVG(200,3,svgRaw + svg + svgHigh);
  }
  totalBufferHigh = [];
}

function onAudioRawTotalClipSuccess() {
  //console.log('onAudioHighTotalClipSuccess:totalRawBuffer=<',totalRawBuffer,'>');
  let peaks = checkPeak2Peak(totalRawBuffer);
  let freqs = calFreq(peaks);
  svgRaw = createWavePolyline(200,0,totalRawBuffer,peaks,freqs);
  if(svg && svgHigh && svgRaw) {
    saveAllSVG(200,3,svgRaw + svg + svgHigh);
  }
  totalRawBuffer = [];
}




function saveAllSVG(height,row,svgRows) {
  let width = Math.max(totalBuffer.length,totalBufferHigh.length,totalRawBuffer.length);
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





const dMinDeltaWave = 0.02;

function checkPeak2Peak(wave) {
  let peakT = [];
  let peakB = [];
  
  let peaks = [];
  let peakPrev = 0.0;
  
  for(let i = 1;i < wave.length -1;i++) {
    if(wave[i] >= wave[i-1] && wave[i] >= wave[i+1]) {
      let delta = Math.abs(peakPrev - wave[i]);
      if(delta > dMinDeltaWave) {
        peakT.push(i);
        peaks.push([i,wave[i]]);
        peakPrev = wave[i];
      }
    }
    if(wave[i] <= wave[i-1] && wave[i] <= wave[i+1]) {
      let delta = Math.abs(peakPrev - wave[i]);
      if(delta > dMinDeltaWave) {
        peakB.push(i); 
        peaks.push([i,wave[i]]);
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
