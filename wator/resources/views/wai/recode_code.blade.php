
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.js" integrity="sha256-t3+U9BqykoMN9cqZmJ5Z53TvPv4V7S9AmjUcIWNNyxo=" crossorigin="anonymous"></script>

<script type="text/javascript">

function onUpdateData(msg) {
  console.log('onUpdateData:msg=<',msg,'>');
}
function onClickRecordBtn(elem) {
  console.log('onClickRecordBtn:elem=<',elem,'>');
  let root = elem.parentElement.parentElement;
  //console.log('onClickRecordBtn:root=<',root,'>');
  let phoneme = root.getElementsByTagName('h4')[0].textContent;
  console.log('onClickRecordBtn:phoneme=<',phoneme,'>');
  doAudioRecord(phoneme);
}

function doAudioRecord(phoneme) {
  console.log('doAudioRecord:phoneme=<',phoneme,'>');
  let mediaConstraints = { audio: true};
  navigator.getUserMedia(mediaConstraints, function(stream) {
      onMediaSuccess(stream,phoneme);
    }, onMediaError);
}
function onMediaSuccess(stream,phoneme) {
  let mr = new MediaRecorder(stream);
  mr.mimeType = 'audio/webm'; // audio/webm or audio/ogg or audio/wav
  let chunks4clip = {};
  let chunks4analyze = [];
  let clipIndex = 0;
  mr.ondataavailable = function (e) {
    //console.log('ondataavailable:e=<',e,'>');
    //console.log('ondataavailable:phoneme=<',phoneme,'>');
    //console.log('ondataavailable:window.URL=<',window.URL,'>');
    chunks4clip[clipIndex++] = e.data;
    chunks4analyze.push(e.data);
   //saveToFile(chunks,phoneme);
   //uploadSlice(chunks,phoneme);
  }
  mr.onerror = function (e) {
    console.log('error:e=<',e,'>');
  }
  mr.onstart = function (e) {
    console.log('onstart:e=<',e,'>');
  }
  mr.onstop = function (e) {
    console.log('onstop:e=<',e,'>');
    console.log('onstop:chunks4clip=<',chunks4clip,'>');
    console.log('onstop:chunks4analyze=<',chunks4analyze,'>');
    analyzeBlobWebm(chunks4analyze);
  }
  mr.start(50);
  setTimeout(function(){
    mr.stop();
  },2000);
}
function onMediaError(e) {
  console.error('media error e=<', e,'>');
}

let AudioContext = window.AudioContext || window.webkitAudioContext;
let audioCtx = new AudioContext();

function analyzeBlobWebm(chunks) {
  console.log('analyzeBlobWebm chunks=<',chunks,'>');
  const blob = new Blob(chunks, { type: 'audio/webm' });
  let urlBlob = window.URL.createObjectURL(blob);
  let audioElem = document.getElementById('wai-recoder-audio-train');
  audioElem.src = urlBlob;
  console.log('analyzeBlobWebm audioElem=<',audioElem,'>');
  let reader = new FileReader();
  reader.onload = function() {
    audioCtx.decodeAudioData(reader.result, function(decodedData) {
      console.log('analyzeBlobWebm decodedData=<',decodedData,'>');
      for( let i = 0;i < decodedData.numberOfChannels;i++) {
        let data = decodedData.getChannelData(i);
        showWaveChart(data,'wai-recoder-canvas-train');
      }
    });
  };
  reader.readAsArrayBuffer(blob);
}

let chartConfig = {
    type: 'line',
    data: ''
}


function showWaveChart(data,idCanvas) {
  console.log('showWaveChart data=<',data,'>');
  console.log('showWaveChart idCanvas=<',idCanvas,'>');
  let ctx = document.getElementById(idCanvas).getContext('2d');
  chartConfig.data = data;
  chartConfig.data.push(1.0);
  chartConfig.data.push(-1.0);
  let wavchar = new Chart(ctx,chartConfig);
}




</script>
