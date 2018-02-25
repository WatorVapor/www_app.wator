
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.js" integrity="sha256-t3+U9BqykoMN9cqZmJ5Z53TvPv4V7S9AmjUcIWNNyxo=" crossorigin="anonymous"></script>
<script type="text/javascript">
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
  clipPhoneme(data,waveEnergyMax,waveEnergyMaxIndex,sample); 
}
</script>
