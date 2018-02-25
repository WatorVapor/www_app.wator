
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.js" integrity="sha256-t3+U9BqykoMN9cqZmJ5Z53TvPv4V7S9AmjUcIWNNyxo=" crossorigin="anonymous"></script>

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
        let position = showWaveChart(data,sample,'wai-recoder-canvas-train');
        console.log('analyzeBlobWebm position=<',position,'>');
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
const SamplingDropRate = 192;
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
  
  let wavchar = new Chart(ctx,chartConfig);
  
  let buffer = audioCtx.createBuffer(1, ClipDurationInSec *sample , sample);
  let audioData = buffer.getChannelData(0);
  let startClipBuffer = waveEnergyMaxIndex - clipWindowSize;
  for(var i = 0; i < audioData.length; i++) {
      audioData[i] = data[i + startClipBuffer];
  }
  let nodeSrc = audioCtx.createBufferSource();
  nodeSrc.buffer = buffer;
  let dest = audioCtx.createMediaStreamDestination();
  let mediaRecorder = new MediaRecorder(dest.stream);
  mediaRecorder.mimeType = 'audio/webm';
  nodeSrc.connect(audioCtx.destination);
  console.log('showWaveChart nodeSrc=<',nodeSrc,'>');
  let chunks = [];
  mediaRecorder.ondataavailable = function(evt) {
    chunks.push(evt.data);
    console.log('showWaveChart evt=<',evt,'>');
  };
  mediaRecorder.onstop = function(evt) {
    let blobClip = new Blob(chunks, { 'type' : 'audio/webm' });
    console.log('showWaveChart blobClip=<',blobClip,'>');
    let urlBlob = window.URL.createObjectURL(blobClip);
    console.log('doClipWave urlBlob=<',urlBlob,'>');
    let audioElem = document.getElementById('wai-recoder-audio-train');
    audioElem.src = urlBlob;
    //audioElem.play();
  };
  nodeSrc.connect(dest);
  mediaRecorder.start();
  nodeSrc.start(0);
  setTimeout(function(){
    mediaRecorder.stop();
  },1000);
  //return waveEnergyMaxIndex / data.length ;
}
</script>
