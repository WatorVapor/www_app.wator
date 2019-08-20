@extends('wator.app')
@section('appnavbar')
  @include('wai.navbar')
@endsection
@section('content')
<div class="row justify-content-center">
  <div class="col-10 text-center mt-5">
    <h1>日语发音练习</h1>
  </div>
</div>

<hr/>


<div class="row justify-content-center">
  <div class="col-10 text-center mt-1">
    <h1>あ</h1>
  </div>
</div>
<div class="row justify-content-center">
  <div class="col-8 text-center mt-1">
    <audio>
      <source src="/wator/audio/ja50on/あ.wav" type="audio/wav">
    </audio>
    <button type="button" class="btn btn-primary btn-lg" onclick="onUIClickPlayPronounce(this)">
      <i class="material-icons md-48">hearing</i>
    </button>
  </div>
</div>



<div class="row justify-content-center mt-5">
  <div class="col-5 text-center mt-5">
    <h5>标准发音波形</h5>
    <canvas id="standardChart"></canvas>
  </div>
  <div class="col-2 text-center mt-5">
    <button type="button" class="btn btn-primary btn-lg">
      <i class="material-icons md-48">settings_voice</i>
    </button>
  </div>
  <div class="col-5 text-center mt-5">
    <h5>你的发音波形</h5>
  </div>
</div>


<script>
  let gBoolIsPlay = false;
  let source = false;
  let scriptNode = false;
  const audioCtx = new AudioContext();
  
  const onUIClickPlayPronounce = (elem) => {
    console.log('onUIClickPlayPronounce::elem=<',elem,'>');
    const audioElem = elem.parentElement.getElementsByTagName('audio')[0];
    console.log('onUIClickPlayPronounce::audioElem=<',audioElem,'>');
    audioElem.addEventListener("ended", (evt)=>{
      console.log('onUIClickPlayPronounce::ended evt=<',evt,'>');
      gBoolIsPlay = false;
    });
    gBoolIsPlay = true;
    drawWaveForm(audioElem);
    audioElem.play();
  }
  const drawWaveForm = (audioElem) => {
    source = audioCtx.createMediaElementSource(audioElem);
    scriptNode = audioCtx.createScriptProcessor(4096, 1, 1);    
    scriptNode.onaudioprocess = onAudioData;
    
    source.connect(scriptNode);
    scriptNode.connect(audioCtx.destination);
  }
  let gAudioData = [];
  onAudioData = (evt) => {
    if(source && scriptNode && gBoolIsPlay == false) {
      source.disconnect(scriptNode);
      scriptNode.disconnect(audioCtx.destination);
      setTimeout(() => {
        onDrawWave(gAudioData)
      },1000);
    }
    console.log('onAudioData::evt=<',evt,'>');
    const inputBuffer = evt.inputBuffer;
    const outputBuffer = evt.outputBuffer;
    //console.log('onAudioData::inputBuffer=<',inputBuffer,'>');
    for (let channel = 0; channel < outputBuffer.numberOfChannels; channel++) {
      const inputData = inputBuffer.getChannelData(channel);
      const outputData = outputBuffer.getChannelData(channel);
      for (let sample = 0; sample < inputBuffer.length; sample++) {
        outputData[sample] = inputData[sample];
        gAudioData.push(inputData[sample]);
      }
    }
  }
  onDrawWave = (data) => {
    console.log('onDrawWave::data=<',data,'>');
    const ctx = document.getElementById("standardChart");
    const graph = {
      type: 'line',
      data: {
        labels:[],
        datasets: [ 
          {
            label: '',
            data:data,
            borderColor: 'blue',
          }
        ]
      },
      options: {
        scales: {
          xAxes: [{
            ticks: {
              display: false,
            },
          }],
          yAxes: [{
            ticks: {
              display: false,
            },
          }]
        },
      }      
    };
    for(let i = 0;i < data.length;i++) {
      graph.data.labels.push(i);
    }
    const myLineChart = new Chart(ctx,graph);
  }
  
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css" integrity="sha256-aa0xaJgmK/X74WM224KMQeNQC2xYKwlAt08oZqjeF0E=" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js" integrity="sha256-arMsf+3JJK2LoTGqxfnuJPFTU4hAK57MtIPdFpiHXOU=" crossorigin="anonymous"></script>


@endsection

