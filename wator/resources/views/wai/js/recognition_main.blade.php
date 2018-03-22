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
  let jsProcess = audioCtx.createScriptProcessor(256, 1, 1);
  jsProcess.onaudioprocess = onAudioProcess;
  source.connect(jsProcess);
  jsProcess.connect(audioCtx.destination);
}



let canvas = document.getElementById('wai-recognition-wave');
let ctx = canvas.getContext('2d');


function onAudioProcess(evt) {
  //console.log('onAudioProcess:evt=<',evt,'>');
  let width = canvas.width;
  let height = canvas.height;
  //console.log('onAudioProcess:width=<',width,'>');
  //console.log('onAudioProcess:height=<',height,'>');
  
  let pink = height/2;
  
  ctx.beginPath();
  ctx.clearRect(0, 0, width, height);
  ctx.strokeStyle = 'rgba(0, 255, 0, 1.0)';
  ctx.lineWidth = 0.5;
  ctx.moveTo(0, pink);
  let audioData = evt.inputBuffer.getChannelData(0);
  //console.log('onAudioProcess:input=<',input,'>');
  for(let i = 0;i < audioData.length;i++) {
    let x= width *i /audioData.length;
    let y = pink + audioData[i] * pink;
    //console.log('onAudioProcess:x=<',x,'>');
    //console.log('onAudioProcess:y=<',y,'>');
    ctx.lineTo(x, y);
  }
  ctx.stroke();
  checkPink2Pink(audioData);
  
}

function checkPink2Pink(wave) {
  //let pinkT = wave[0];
  //let pinkB = wave[0];
  let pingT = [];
  let pingB = [];
  
  for(let i = 1;i < wave.length -1;i++) {
    if(wave[i] > wave[i-1] && wave[i] > wave[i+1]) {
      pingT.push(i); 
    }
    if(wave[i] < wave[i-1] && wave[i] < wave[i+1]) {
      pingB.push(i); 
    }
  }
  console.log('checkPink2Pink:pingT=<',pingT,'>');
  console.log('checkPink2Pink:pingB=<',pingB,'>');
}


</script>
