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


function onMediaSuccess(stream) {
  console.log('onMediaSuccess:stream=<',stream,'>');
  let source = audioCtx.createMediaStreamSource(stream);
  let filter = audioCtx.createBiquadFilter();
  filter.type = 'lowpass';
  filter.frequency.value = 1024;
  
  let jsProcess = audioCtx.createScriptProcessor(16384, 1, 1);
  jsProcess.onaudioprocess = onAudioProcess;
  source.connect(filter);
  filter.connect(jsProcess);
  jsProcess.connect(audioCtx.destination);
}



let canvas = document.getElementById('wai-recognition-wave');
let ctx = canvas.getContext('2d');


function onAudioProcess(evt) {
  //console.log('onAudioProcess:evt=<',evt,'>');
  let audioData = evt.inputBuffer.getChannelData(0);
  //console.log('onAudioProcess:input=<',input,'>');
  checkPeak2Peak(audioData);
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
  console.log('checkPeak2Peak:peakT=<',peakT,'>');
  console.log('checkPeak2Peak:peakB=<',peakB,'>');
  drawDataXY(peaks,wave.length);
}

function drawData(wave) {
  let width = canvas.width;
  let height = canvas.height;
  //console.log('drawData:width=<',width,'>');
  //console.log('drawData:height=<',height,'>');
  
  let pink = height/2;
  
  ctx.beginPath();
  ctx.clearRect(0, 0, width, height);
  ctx.strokeStyle = 'green';
  ctx.lineWidth = 5;
  ctx.moveTo(0, pink);
  for(let i = 0;i < wave.length;i++) {
    let x= width * i /wave.length;
    let y = pink + wave[i] * pink;
    //console.log('drawData:x=<',x,'>');
    //console.log('drawData:y=<',y,'>');
    ctx.lineTo(x, y);
    ctx.moveTo(x, y);
  }
  ctx.stroke();
}

function drawDataXY(wave,length) {
  let width = canvas.width;
  let height = canvas.height;
  //console.log('drawData:width=<',width,'>');
  //console.log('drawData:height=<',height,'>');
  
  let pink = height/2;
  
  ctx.beginPath();
  ctx.clearRect(0, 0, width, height);
  ctx.strokeStyle = 'pink';
  ctx.lineWidth = 1;
  //ctx.moveTo(0, pink);
  for(let i = 0;i < wave.length;i++) {
    let absY = Math.abs(wave[i][1]);
    if(absY > 0.01) {
      let x = width * wave[i][0] / length;
      let y = pink + wave[i][1] * pink;
      //console.log('drawData:x=<',x,'>');
      //console.log('drawData:y=<',y,'>');
      ctx.lineTo(x, y);
      ctx.moveTo(x, y);
    }
  }
  ctx.stroke();
}


</script>
