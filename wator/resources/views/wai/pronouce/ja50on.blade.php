@extends('wator.app')
@section('appnavbar')
  @include('wai.navbar')
@endsection
@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/videojs-wavesurfer/2.9.0/css/videojs.wavesurfer.min.css" integrity="sha256-Jolz/7jUfpSE0SDb35iI7w0FGDW9s8wK8eiiPa5qyOk=" crossorigin="anonymous" />



<div class="row justify-content-center">
  <div class="col-10 text-center mt-5">
    <h1>日语发音练习</h1>
  </div>
</div>

<hr/>
<div class="row justify-content-center">
  <div class="col-5 bg-secondary">
    
    <div class="row justify-content-center">
      <div class="col-2">
        <a class="btn btn-success btn-lg" href="/wai/pronounce/ja50on/あ">あ</a>
      </div>
      <div class="col-2">
        <a class="btn btn-success btn-lg" href="/wai/pronounce/ja50on/い">い</a>
      </div>
      <div class="col-2">
        <a class="btn btn-success btn-lg" href="/wai/pronounce/ja50on/う">う</a>
      </div>
      <div class="col-2">
        <a class="btn btn-success btn-lg" href="/wai/pronounce/ja50on/え">え</a>
      </div>
      <div class="col-2">
        <a class="btn btn-success btn-lg" href="/wai/pronounce/ja50on/お">お</a>
      </div>
    </div>

    <div class="row justify-content-center mt-5">
      <div class="col-2">
        <a class="btn btn-success btn-lg" href="/wai/pronounce/ja50on/か">か</a>
      </div>
      <div class="col-2">
        <a class="btn btn-success btn-lg" href="/wai/pronounce/ja50on/き">き</a>
      </div>
      <div class="col-2">
        <a class="btn btn-success btn-lg" href="/wai/pronounce/ja50on/く">く</a>
      </div>
      <div class="col-2">
        <a class="btn btn-success btn-lg" href="/wai/pronounce/ja50on/け">け</a>
      </div>
      <div class="col-2">
        <a class="btn btn-success btn-lg" href="/wai/pronounce/ja50on/こ">こ</a>
      </div>
    </div>

    <div class="row justify-content-center mt-5">
      <div class="col-2">
        <a class="btn btn-success btn-lg" href="/wai/pronounce/ja50on/が">が</a>
      </div>
      <div class="col-2">
        <a class="btn btn-success btn-lg" href="/wai/pronounce/ja50on/ぎ">ぎ</a>
      </div>
      <div class="col-2">
        <a class="btn btn-success btn-lg" href="/wai/pronounce/ja50on/ぐ">ぐ</a>
      </div>
      <div class="col-2">
        <a class="btn btn-success btn-lg" href="/wai/pronounce/ja50on/げ">げ</a>
      </div>
      <div class="col-2">
        <a class="btn btn-success btn-lg" href="/wai/pronounce/ja50on/ご">ご</a>
      </div>
    </div>
  

    <div class="row justify-content-center mt-5">
      <div class="col-2">
        <a class="btn btn-success btn-lg" href="/wai/pronounce/ja50on/さ">さ</a>
      </div>
      <div class="col-2">
        <a class="btn btn-success btn-lg" href="/wai/pronounce/ja50on/し">し</a>
      </div>
      <div class="col-2">
        <a class="btn btn-success btn-lg" href="/wai/pronounce/ja50on/す">す</a>
      </div>
      <div class="col-2">
        <a class="btn btn-success btn-lg" href="/wai/pronounce/ja50on/せ">せ</a>
      </div>
      <div class="col-2">
        <a class="btn btn-success btn-lg" href="/wai/pronounce/ja50on/そ">そ</a>
      </div>
    </div>


    <div class="row justify-content-center mt-5">
      <div class="col-2">
        <a class="btn btn-success btn-lg" href="/wai/pronounce/ja50on/ざ">ざ</a>
      </div>
      <div class="col-2">
        <a class="btn btn-success btn-lg" href="/wai/pronounce/ja50on/じ">じ</a>
      </div>
      <div class="col-2">
        <a class="btn btn-success btn-lg" href="/wai/pronounce/ja50on/ず">ず</a>
      </div>
      <div class="col-2">
        <a class="btn btn-success btn-lg" href="/wai/pronounce/ja50on/ぜ">ぜ</a>
      </div>
      <div class="col-2">
        <a class="btn btn-success btn-lg" href="/wai/pronounce/ja50on/ぞ">ぞ</a>
      </div>
    </div>

  
  </div>
  
  <div class="col-2">
    <div class="row justify-content-start">
      <div class="col-1 text-center mt-1 ml-3">
        <h1>{{ $yinjie }}</h1>
      </div>
    </div>
    <div class="row justify-content-start">
      <div class="col-1 text-center mt-1 ml-3">
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
  
  <div class="col-5">
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

<script src="https://unpkg.com/wavesurfer.js/dist/wavesurfer.js"></script>
<script src="https://unpkg.com/wavesurfer.js/dist/plugin/wavesurfer.regions.js"></script>
<script src="https://unpkg.com/wavesurfer.js/dist/plugin/wavesurfer.microphone.js"></script>

<script>
  let wavesurfer = false;  
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
  let wavesurferMine = false;  
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

</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css" integrity="sha256-aa0xaJgmK/X74WM224KMQeNQC2xYKwlAt08oZqjeF0E=" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js" integrity="sha256-arMsf+3JJK2LoTGqxfnuJPFTU4hAK57MtIPdFpiHXOU=" crossorigin="anonymous"></script>


@endsection

