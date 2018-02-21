
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.js" integrity="sha256-t3+U9BqykoMN9cqZmJ5Z53TvPv4V7S9AmjUcIWNNyxo=" crossorigin="anonymous"></script>

<script type="text/javascript">

const RECORD_TIME_MS = 1500;

function onUpdateData(msg) {
  console.log('onUpdateData:msg=<',msg,'>');
}
function onClickRecordBtn(elem) {
  console.log('onClickRecordBtn:elem=<',elem,'>');
  
  let timerCounterMax = RECORD_TIME_MS/300 -2; 
  let timerCounter = RECORD_TIME_MS/300 -2; 

  let parent = elem.parentElement;
  console.log('onClickRecordBtn:parent=<',parent,'>');
  let progress = parent.getElementsByClassName('progress-bar')[0];
  console.log('onClickRecordBtn:progress=<',progress,'>');
  progress.style.cssText ='width: 100%;'; 
  let timer = setInterval( function() {
    let percentage = 100*timerCounter/timerCounterMax;
    progress.style.cssText ='width: ' + percentage + '%;'; 
    if(timerCounter-- <= 0) {
      clearInterval(timer);
    }
  },300);

  let root = elem.parentElement.parentElement.parentElement.parentElement;
  console.log('onClickRecordBtn:root=<',root,'>');
  let phoneme = root.getElementsByTagName('h1')[0].textContent;
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
  },RECORD_TIME_MS);
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
        let sample = decodedData.sampleRate;
        showWaveChart(data,sample,'wai-recoder-canvas-train');
      }
    });
  };
  reader.readAsArrayBuffer(blob);
}



let chartConfig = {
  type: 'line',
  data: {
    labels: [],
    datasets: [
    {
      label: '',
      backgroundColor: 'red',
      borderColor: 'red',
      data: [],
      fill: false,
      pointRadius: 1,
      borderWidth:1
     },
    {
      label: '',
      backgroundColor: 'blue',
      borderColor: 'blue',
      data: [],
      fill: false,
      pointRadius: 1,
      borderWidth:1
     }
    ]
  },
  options: {
    responsive: true,
    maintainAspectRatio: true,
    animation: false,
    legend: {
        display: false
    },
  scales: {
    xAxes: [{
      display: false,
      ticks: {
        stepSize: 100
      },
      gridLines: {
        display: false
      },
      scaleLabel: {
        display: false
      }
    }],
    yAxes: [{
      ticks: {
        min: -1.0,
        max: 1.0,
      },
      display: false,
      gridLines: {
        display: false,
      },
      scaleLabel: {
        display: false
      }
    }]
  }
  }
}

const SamplingDropRate = 96;
const ClipDurationInSec = 0.25;

function showWaveChart(data,sample,idCanvas) {
  console.log('showWaveChart data=<',data,'>');
  console.log('showWaveChart sample=<',sample,'>');
  console.log('showWaveChart idCanvas=<',idCanvas,'>');
  let canvas = document.getElementById(idCanvas);
  console.log('showWaveChart canvas=<',canvas,'>');
  let ctx = canvas.getContext('2d');
  
  let width = canvas.offsetWidth;
  console.log('showWaveChart width=<',width,'>');
  

  let skipCounter = 0;
  chartConfig.data.datasets[0].data = [];
  
  let clipWindowSize = ClipDurationInSec * sample;
  console.log('showWaveChart clipWindowSize=<',clipWindowSize,'>');
  
  let waveEnergy = 0.0;
  let waveEnergyMax = 0.0;
  let waveEnergyMaxIndex = 0.0;
  for(let i = 0;i < data.length;i++) {
    if(skipCounter++% SamplingDropRate === 0) {
      chartConfig.data.datasets[0].data.push(data[i]);
    }
    waveEnergy += Math.abs(data[i]);
    if(i > clipWindowSize) {
      let j = i - clipWindowSize;
      waveEnergy -= Math.abs(data[j]);
    }
    if(waveEnergy > waveEnergyMax) {
      waveEnergyMax = waveEnergy;
      waveEnergyMaxIndex = i;
    }
  }
  console.log('showWaveChart waveEnergyMax=<',waveEnergyMax,'>');
  console.log('showWaveChart waveEnergyMaxIndex=<',waveEnergyMaxIndex,'>');
  let clipData = (new Array(chartConfig.data.datasets[0].data.length)).fill(0);
  console.log('showWaveChart clipData=<',clipData,'>');
  chartConfig.data.datasets[1].data = clipData;
  
  let clipStart = Math.floor((waveEnergyMaxIndex - clipWindowSize)/SamplingDropRate);
  let clipEnd = Math.floor(waveEnergyMaxIndex/SamplingDropRate);
  console.log('showWaveChart clipStart=<',clipStart,'>');
  console.log('showWaveChart clipEnd=<',clipEnd,'>');
  for(let j = clipStart;j < clipEnd;j++) {
    chartConfig.data.datasets[1].data[j] = 1.0;
  }
  
  chartConfig.data.labels = chartConfig.data.datasets[0].data;

  //let maxY = Math.max.apply(null, chartConfig.data.datasets[0].data);
  //let minY = Math.min.apply(null, chartConfig.data.datasets[0].data);
  //console.log('showWaveChart maxY=<',maxY,'>');
  //console.log('showWaveChart minY=<',minY,'>');

  //console.log('showWaveChart chartConfig.data.datasets[0].data=<',chartConfig.data.datasets[0].data,'>');

  //chartConfig.options.scales.yAxes[0].ticks.max = maxY;
  //chartConfig.options.scales.yAxes[0].ticks.min = minY;
  let wavchar = new Chart(ctx,chartConfig);
}



</script>
