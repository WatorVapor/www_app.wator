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
  let filter = audioCtx.createBiquadFilter();
  filter.type = 'lowpass';
  filter.frequency.value = 16384;
  
  let jsProcess = audioCtx.createScriptProcessor(16384, 1, 1);
  jsProcess.onaudioprocess = onAudioProcess;
  source.connect(filter);
  filter.connect(jsProcess);
  jsProcess.connect(audioCtx.destination);
  setTimeout(function(){
    jsProcess.disconnect();
  },RECORD_TIME_MS);
  
  setTimeout(function(){
    onAudioTotalClipSuccess();
  },RECORD_TIME_MS + 1000);
}

let totalBuffer = [];
function onAudioProcess(evt) {
  //console.log('onAudioProcess:evt=<',evt,'>');
  let audioData = evt.inputBuffer.getChannelData(0);
  //console.log('onAudioProcess:audioData=<',audioData,'>');
  totalBuffer.push(...audioData);
}

function onAudioTotalClipSuccess() {
  //console.log('onAudioTotalClipSuccess:totalBuffer=<',totalBuffer,'>');
  let peaks = checkPeak2Peak(totalBuffer);
  let freqs = calFreq(peaks);
  createWaveSVG(totalBuffer,peaks,freqs);
  totalBuffer = [];
}

function createWaveSVG(wave,peaks,freqs) {
  //console.log('createWaveSVG:wave=<',wave,'>');
  let width = wave.length;
  let height = 400;
  let peak = height/2;
  //console.log('createWaveSVG:width=<',width,'>');
  //console.log('createWaveSVG:height=<',height,'>');
  let svg = '<svg width="';
  svg += width;
  svg += '" height="';
  svg += height;
  svg += '" xmlns="http://www.w3.org/2000/svg">';
  svg += '\n';
  
  svg += '<polyline points="';
  for(let i = 0;i < wave.length ;i++) {
    let y = peak - wave[i] * peak;
    let x = i;
    svg +=  ' ' + x  + ',' + y;
  }
  svg += '"';
  svg += '\n';
  svg += ' fill="none" stroke="red" stroke-width="1" />';

  svg += '<polyline points="';
  for(let i = 0;i < peaks.length ;i++) {
    let y = peak - peaks[i][1] * peak;
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
    svg += '<text x="';
    svg += x;
    svg += '" y="';
    svg += y;
    svg += '">';
    svg += peaks[i][0] %100;
    svg +=  '</text>';
  }
*/

  for(let i = 0;i < freqs.length ;i++) {
    let y = peak;
    let x = freqs[i][0];
    svg += '<text x="';
    svg += x;
    svg += '" y="';
    svg += y;
    svg += '">';
    svg += freqs[i][1];
    svg +=  '</text>';
  }


  svg += '<polyline points="';
  svg += ' 0,' + peak + ' ';
  svg += width +',' + peak + ' ';
  svg += '"';
  svg += '\n';
  svg += ' fill="none" stroke="blue" stroke-width="1" />';

  svg += '\n';
  svg += '</svg>';
  //console.log('createWaveSVG:svg=<',svg,'>');
  
  let blob = new Blob([svg], {type: "image/svg+xml;charset=utf-8"});
  let urlBlob = window.URL.createObjectURL(blob);
  console.log('createWaveSVG:urlBlob=<',urlBlob,'>');
  let img = document.getElementById('wai-recognition-wave');
  img.src = urlBlob;
  var a = document.createElement('a');
  a.href = urlBlob;
  a.download = 'wai.recog_fix.svg';
  a.click();
  //document.body.removeChild(a);
}

function checkPeak2Peak(wave) {
  let peakT = [];
  let peakB = [];
  
  let peaks = [];
  
  for(let i = 1;i < wave.length -1;i++) {
    if(wave[i] > wave[i-1] && wave[i] > wave[i+1]) {
      peakT.push(i);
      peaks.push([i,wave[i]]);
    }
    if(wave[i] < wave[i-1] && wave[i] < wave[i+1]) {
      peakB.push(i); 
      peaks.push([i,wave[i]]);
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
    freqs.push([index,freq]);
  }
  console.log('calFreq:freqs=<',freqs,'>');
  return freqs;
}



</script>
