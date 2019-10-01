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
  const iConstRecorderSlice = 50;
  const iConstRecorderTotal = 1500;
  let wavesurferMine = false;
  let durationMine = false;  
  let wavesurferMineClip = false;
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

    wavesurferMineClip = WaveSurfer.create({
      container:document.querySelector('#clipWaveform'),
      waveColor:'red',
      progressColor: 'orange',
      backend: 'MediaElement',
      mediaControls: false
    });
    wavesurferMineClip.once('ready', () => {
      console.log('onLoaded50OnRec:: WaveSurfer.VERSION=<', WaveSurfer.VERSION,'>');
      durationMine = wavesurferMineClip.getDuration();
      console.log('onLoaded50OnRec:: durationMine=<', durationMine,'>');
    });
    wavesurferMineClip.on('error', (e) =>{
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
            console.log('onUIClickRecordPronounce maxEnergyBuffer=<',maxEnergyBuffer,'>');
            createAudioMaxEnergyAudio(maxEnergyBuffer,decodedData.sampleRate);
          }
        });
      };
      reader.readAsArrayBuffer(recBlob);
    
    });    
    setTimeout(()=>{
      mediaRecorder.stop();
    },iConstRecorderTotal);
    mediaRecorder.start(iConstRecorderSlice);
  }

  const onUIClickPlayRecordPronounce = (elem) => {
    console.log('onUIClickPlayRecordPronounce::elem=<',elem,'>');
    wavesurferMineClip.playPause();
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
    return {data:data.slice(maxEnergyIndex, end),start:maxEnergyIndex,end:end};
  }
  
  const createAudioMaxEnergyAudio = (clipData,sampleRate) =>{
    console.log('createAudioMaxEnergyAudio clipData=<',clipData,'>');
    const recAudioCtx = new AudioContext();
    const frameCount = clipData.data.length;
    const myArrayBuffer = recAudioCtx.createBuffer(1, frameCount, recAudioCtx.sampleRate);
    console.log('createAudioMaxEnergyAudio myArrayBuffer=<',myArrayBuffer,'>');
    for (let channel = 0; channel < myArrayBuffer.numberOfChannels; channel++) {
      const nowBuffering = myArrayBuffer.getChannelData(channel);
      for (let i = 0; i < frameCount; i++) {
        nowBuffering[i] = clipData.data[i];
      }
    }
    const soundSource = recAudioCtx.createBufferSource();
    soundSource.buffer = myArrayBuffer;
    let dest = recAudioCtx.createMediaStreamDestination();
    let clipRecorder = new MediaRecorder(dest.stream);
    clipRecorder.mimeType = 'audio/webm';
    const clipChunks = []
    clipRecorder.ondataavailable = function(evt) {
      console.log('createAudioMaxEnergyAudio evt=<',evt,'>');
      clipChunks.push(evt.data);
    }
    clipRecorder.onstop = function(evt) {
      console.log('createAudioMaxEnergyAudio evt=<',evt,'>');
      console.log('createAudioMaxEnergyAudio clipChunks=<',clipChunks,'>');
      
      const clipBlob = new Blob(clipChunks);
      let audioClip = new Audio();
      audioClip.src = URL.createObjectURL(clipBlob);
      wavesurferMineClip.load(audioClip);
      $('#ui-audio-record-play').removeClass('d-none');
    }
    
    soundSource.connect(dest);
    soundSource.connect(recAudioCtx.destination);
    soundSource.start(0);
    clipRecorder.start();
    setTimeout(()=>{
      clipRecorder.stop();
    },myArrayBuffer.duration * 1000)
  }

</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css" integrity="sha256-aa0xaJgmK/X74WM224KMQeNQC2xYKwlAt08oZqjeF0E=" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js" integrity="sha256-arMsf+3JJK2LoTGqxfnuJPFTU4hAK57MtIPdFpiHXOU=" crossorigin="anonymous"></script>
