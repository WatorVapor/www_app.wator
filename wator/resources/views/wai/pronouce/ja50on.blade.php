@extends('wator.app')
@section('appnavbar')
  @include('wai.navbar')
@endsection
@section('content')
<div class="row justify-content-center">
  <div class="col-10 text-center mt-1">
    <h1>日语发音练习</h1>
  </div>
</div>
<hr/>
<div class="row justify-content-center"> 
  <div class="col-2">
    <div class="row justify-content-start">
      <div class="col-6 text-center mt-1">
        <h1>{{ $yinjie }}</h1>
      </div>
    </div>
    <div class="row justify-content-start">
      <div class="col-6 text-center mt-1">
        <audio class="d-none">
          <source id="ui-audio-standard-source" src="/wator/audio/ja50on/{{ $yinjie }}.wav" type="audio/wav">
        </audio>
        <button type="button" class="btn btn-primary btn-lg" onclick="onUIClickPlayStandardPronounce(this)">
          <i class="material-icons md-48">hearing</i>
        </button>
      </div>
    </div>
    
    <div class="row justify-content-start mt-5">      
      <div class="col text-center mt-5">
        <button type="button" class="btn btn-primary btn-lg" onclick="onUIClickRecordPronounce(this)">
          <i class="material-icons md-48">settings_voice</i>
        </button>
      </div>
       <div class="col text-center mt-5">
        <button type="button" class="btn btn-primary btn-lg d-none" id="ui-audio-record-play" onclick="onUIClickPlayRecordPronounce(this)">
          <i class="material-icons md-48">play_arrow</i>
        </button>
      </div>
    </div>    
  </div>
  
  <div class="col-10">
    <div class="row justify-content-center mt-1">
      <div class="col text-center mt-1">
        <h5>标准波形</h5>
        <div id="standarddWaveform"></div>
      </div>
    </div>
    <div class="row justify-content-center mt-1">      
     <div class="col text-center mt-1">
        <div id="mineWaveform"></div>
        <h5>我的波形</h5>
      </div>
    </div>

  </div>
</div>
<hr/>
<div class="row justify-content-center">
  @include('wai.pronouce.hiragana')
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/7.3.0/adapter.min.js" integrity="sha256-2qQheewaqnZlXJ3RJRghVUwD/3fD9HNqxh4C+zvgmF4=" crossorigin="anonymous"></script>

<script src="https://unpkg.com/wavesurfer.js"></script>
<script src="https://unpkg.com/wavesurfer.js/dist/plugin/wavesurfer.regions.min.js"></script>

<script>
  let wavesurfer = false;
  let sourceDuation = false;
  const onLoaded50On = () =>{
    wavesurfer = WaveSurfer.create({
      container: document.querySelector('#standarddWaveform'),
      waveColor: '#A8DBA8',
      progressColor: '#3B8686',
      backend: 'MediaElement',
      mediaControls: false
    });
    const audioSourceElem = document.getElementById('ui-audio-standard-source');
    wavesurfer.load(audioSourceElem.src);
    wavesurfer.once('ready', () => {
      console.log('onLoaded50On:: WaveSurfer.VERSION=<', WaveSurfer.VERSION,'>');
      sourceDuation = wavesurfer.getDuration();
      console.log('onLoaded50On:: sourceDuation=<', sourceDuation,'>');
    });
    wavesurfer.on('error', (e) =>{
      console.warn('onLoaded50On:: e=<', e,'>');
    });

  };
  document.addEventListener('DOMContentLoaded', onLoaded50On);
  
  const onUIClickPlayStandardPronounce = (elem) => {
    console.log('onUIClickPlayStandardPronounce::elem=<',elem,'>');
    wavesurfer.playPause();
  }

</script>


<script>
  const AudioContext = window.AudioContext || window.webkitAudioContext;
  const audioCtx = new AudioContext();
  let wavesurferMine = false;
  let durationMine = false;  
  const onLoaded50OnRec = (evt) =>{
    console.log('onLoaded50OnRec::evt=<',evt,'>');
    wavesurferMine = WaveSurfer.create({
      container:document.querySelector('#mineWaveform'),
      waveColor:'red',
      progressColor: 'orange',
      backend: 'MediaElement',
      mediaControls: false
    });
    wavesurferMine.once('ready', () => {
      console.log('onLoaded50OnRec:: WaveSurfer.VERSION=<', WaveSurfer.VERSION,'>');
      durationMine = wavesurferMine.getDuration();
      console.log('onLoaded50OnRec:: durationMine=<', durationMine,'>');
    });
    wavesurferMine.on('error', (e) =>{
      console.warn('onLoaded50OnRec:: e=<', e,'>');
    });
  };
  document.addEventListener('DOMContentLoaded', onLoaded50OnRec);
  
  const onUIClickRecordPronounce = (elem) => {
    console.log('onUIClickRecordPronounce::elem=<',elem,'>');
    navigator.mediaDevices.getUserMedia({ audio: true, video: false }).then(handleSuccess);
    $('#ui-audio-record-play').addClass('d-none');
  }
  const handleSuccess = (stream) => {
  const options = {mimeType: 'audio/webm'};
  const recordedChunks = [];
  const mediaRecorder = new MediaRecorder(stream, options);

  mediaRecorder.addEventListener('dataavailable', function(e) {
    if (e.data.size > 0) {
      recordedChunks.push(e.data);
    }       
  });
  mediaRecorder.addEventListener('stop', function() {
    //console.log('handleSuccess::recordedChunks=<',recordedChunks,'>');
    const recBlob = new Blob(recordedChunks);
    //console.log('handleSuccess::recBlob=<',recBlob,'>');
    let audio = new Audio();
    audio.src = URL.createObjectURL(recBlob);
    wavesurferMine.load(audio);
    $('#ui-audio-record-play').removeClass('d-none');

    const reader = new FileReader();
    reader.onload = function() {
      audioCtx.decodeAudioData(reader.result, function(decodedData) {
        console.log('onUIClickRecordPronounce decodedData=<',decodedData,'>');
        // channel 1 only.
        if(decodedData.numberOfChannels > 0){
          const data = decodedData.getChannelData(0);
          const sample = decodedData.sampleRate;
          //console.log('onUIClickRecordPronounce sample=<',sample,'>');
          //console.log('onUIClickRecordPronounce decodedData.duration=<',decodedData.duration,'>');
          //console.log('onUIClickRecordPronounce sourceDuation=<',sourceDuation,'>');
          const maxEnergyWindow = Math.floor(sourceDuation * decodedData.sampleRate);
          //console.log('onUIClickRecordPronounce maxEnergyWindow=<',maxEnergyWindow,'>');
          const maxEnergyBuffer = calcMaxEnergyInDuration(data,maxEnergyWindow);
          //console.log('onUIClickRecordPronounce maxEnergyBuffer=<',maxEnergyBuffer,'>');
          createAudioMaxEnergyAudio(maxEnergyBuffer,decodedData.sampleRate);
        }
      });
    };
    reader.readAsArrayBuffer(recBlob);
  
  });    
  setTimeout(()=>{
    mediaRecorder.stop();
  },1500);
  mediaRecorder.start();
  }

  const onUIClickPlayRecordPronounce = (elem) => {
    console.log('onUIClickPlayRecordPronounce::elem=<',elem,'>');
    wavesurferMine.playPause();
  }
  
  const calcMaxEnergyInDuration = (data,windowSize) =>{
    //console.log('calcMaxEnergyDuration windowSize=<',windowSize,'>');
    //console.log('calcMaxEnergyDuration data=<',data,'>');
    let sumEnergy = 0;
    let maxEnergy = 0;
    let maxEnergyIndex = 0;
    for(let index = 0;index < data.length;index++) {
      sumEnergy += Math.abs(data[index]);
      if(index > windowSize) {
        const leftIndex = index - windowSize;
        sumEnergy -= Math.abs(data[leftIndex]);
        if(sumEnergy > maxEnergy) {
          maxEnergy = sumEnergy;
          maxEnergyIndex = leftIndex;
        }
      }
    }
    console.log('calcMaxEnergyDuration sumEnergy=<',sumEnergy,'>');
    console.log('calcMaxEnergyDuration maxEnergy=<',maxEnergy,'>');
    console.log('calcMaxEnergyDuration maxEnergyIndex=<',maxEnergyIndex,'>');
    let end = maxEnergyIndex + windowSize;
    if(end > data.length) {
      end = data.length;
    }
    return data.slice(maxEnergyIndex, end);
  }
  
  const createAudioMaxEnergyAudio = (data,sampleRate) =>{
    //console.log('createAudioMaxEnergyAudio data=<',data,'>');
    /*
    const maxBlob = new Blob([data], {type: "audio/wav"});
    console.log('createAudioMaxEnergyAudio maxBlob=<',maxBlob,'>');
    let audio = new Audio();
    audio.src = URL.createObjectURL(maxBlob);
    wavesurferMine.load(audio);
    */
    const offlineAudioCtx = new OfflineAudioContext(1,data.length,sampleRate);
    const frameCount = data.length;
    const myArrayBuffer = offlineAudioCtx.createBuffer(1, frameCount, offlineAudioCtx.sampleRate);
    console.log('createAudioMaxEnergyAudio myArrayBuffer=<',myArrayBuffer,'>');
    for (let channel = 0; channel < myArrayBuffer.numberOfChannels; channel++) {
      const nowBuffering = myArrayBuffer.getChannelData(channel);
      for (let i = 0; i < frameCount; i++) {
        nowBuffering[i] = data[i];
      }
    }
    const soundSource = offlineAudioCtx.createBufferSource();
    soundSource.buffer = myArrayBuffer;
    const compressor = offlineAudioCtx.createDynamicsCompressor();
    soundSource.connect(compressor);
    compressor.connect(offlineAudioCtx.destination);
    soundSource.start();
    /*
    OfflineAudioContext.oncomplete = function(e) {
    export(e.renderedBuffer)
    };
    */
    offlineAudioCtx.startRendering().then(function(renderedBuffer) {
      console.log('createAudioMaxEnergyAudio renderedBuffer=<',renderedBuffer,'>');
    }).catch(function(err) {
      console.log('createAudioMaxEnergyAudio err=<',err,'>');
    });

  }

</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css" integrity="sha256-aa0xaJgmK/X74WM224KMQeNQC2xYKwlAt08oZqjeF0E=" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js" integrity="sha256-arMsf+3JJK2LoTGqxfnuJPFTU4hAK57MtIPdFpiHXOU=" crossorigin="anonymous"></script>


@endsection

