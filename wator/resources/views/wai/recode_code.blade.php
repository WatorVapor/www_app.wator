
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
  data: {
    labels: [],
    datasets: [{
      label: '',
      backgroundColor: 'red',
      borderColor: 'red',
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
        stepSize: 1000
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
        beginAtZero: true,
        min: -1.0,
        max: 1.0,
      },
      display: true,
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

//stepSize: 1
const adjustFactor = 100000.0;

function showWaveChart(data,idCanvas) {
  console.log('showWaveChart data=<',data,'>');
  console.log('showWaveChart idCanvas=<',idCanvas,'>');
  let canvas = document.getElementById(idCanvas);
  console.log('showWaveChart canvas=<',canvas,'>');
  let ctx = canvas.getContext('2d');
  
  let width = canvas.offsetWidth;
  console.log('showWaveChart width=<',width,'>');
  
  let maxY = Math.max.apply(null, data);
  let minY = Math.min.apply(null, data);
  console.log('showWaveChart maxY=<',maxY,'>');
  console.log('showWaveChart minY=<',minY,'>');


  chartConfig.data.datasets[0].data = [];
  /*
  chartConfig.data.datasets[0].data.push(adjustFactor*maxY);
  for(let i = 0;i < data.length;i++) {
    if(data[i] > 0.0) {
      let dataAdjust = ( adjustFactor * data[i] )/maxY
      chartConfig.data.datasets[0].data.push(dataAdjust);
    } else {
      let dataAdjust = ( adjustFactor * data[i] )/minY
      chartConfig.data.datasets[0].data.push(dataAdjust);
    }
  }
  chartConfig.data.datasets[0].data.push(adjustFactor*minY);
  */
  sampling(data,chartConfig.data.datasets[0].data,maxY,minY);

  chartConfig.data.labels = chartConfig.data.datasets[0].data;

  console.log('showWaveChart chartConfig.data.datasets[0].data=<',chartConfig.data.datasets[0].data,'>');

  chartConfig.options.scales.yAxes[0].ticks.max = adjustFactor*maxY;
  chartConfig.options.scales.yAxes[0].ticks.min = adjustFactor*minY;
  let wavchar = new Chart(ctx,chartConfig);
}

function sampling(data,output,maxY,minY) {
  let sampleingCounter = 0;
  let sampleingNumber = 1000;
  for(let i = 0;i < data.length;i++) {
    if(sampleingCounter++ % sampleingNumber === 0) {
      if(data[i] > 0.0) {
        let dataAdjust = ( adjustFactor * data[i] )/maxY
        output.push(dataAdjust);
      } else {
        let dataAdjust = ( adjustFactor * data[i] )/minY
        output.push(dataAdjust);
      }
    }
  }
}



</script>
