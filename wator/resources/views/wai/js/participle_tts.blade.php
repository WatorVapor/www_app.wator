<!--

<script type="text/javascript">
let ttsCached = false;

function createTTS(tts) {
  if(ipfs.isReadyMask) {
    //console.log('createTTS:tts=<',tts,'>');
    let clipsElem = document.getElementById('ui-update-tts-all-clips');
    //console.log('onClickTTS:clipsElem=<',clipsElem,'>');
    if(tts.length > 0){
      createClipsElement(clipsElem,0,tts);
    }
  } else {
    ttsCached = tts;
  }
}

</script>
<script src="https://unpkg.com/ipfs-api/dist/index.js"></script>
<script type="text/javascript">
const Buffer = window.IpfsApi().Buffer;
let ipfs = window.IpfsApi({host:'www.wator.xyz', port:'443', protocol: 'https'});
ipfs.id(function (err, identity) {
  if (err) {
    throw err
  }
  console.log('ipfs.id:identity=<',identity,'>');
  ipfs.isReadyMask = true;
  if(ttsCached) {
    setTimeout(function(){
      createTTS(ttsCached);
    },1)
  }
});




let AudioContext = window.AudioContext || window.webkitAudioContext;
let audioCtx = new AudioContext();



let totalAudioBuffer = [];
let totalDuration = 0;


function createClipsElement(clipsElem,index,tts) {
  //console.log('createClipsElement:clip=<',clip,'>');
  let clip = tts[index];
  ipfs.files.cat(clip,function(err, file){
    if (err) {
      throw err;
    }
    console.log('createClipsElement:: ipfs.files.cat file=<',file,'>');
    audioCtx.decodeAudioData(file.buffer, function(decodedData) {
      //console.log('createClipsElement decodedData=<',decodedData,'>');
      totalAudioBuffer.push(decodedData);
      totalDuration += decodedData.duration;
      if(tts.length > index +1) {
        createClipsElement(clipsElem,index +1,tts)
      } else {
        $( '.ui-update-tts-enable-audio' ).removeClass( 'd-none' );
        //console.log('createClipsElement:totalDuration=<',totalDuration,'>');
        createLongClip();
      }
    });
    
    /*
    let blob = new Blob([file], { type: 'audio/webm' });
    let urlBlob = window.URL.createObjectURL(blob);
    let audio = document.createElement('audio');
    audio.className = 'ui-update-tts-one-clip';
    audio.setAttribute('id','ui-update-tts-one-clip-' + index);
    audio.src = urlBlob;
    audio.setAttribute('type','audio/webm');
    console.log('createClipsElement:audio=<',audio,'>');
    clipsElem.appendChild(audio);
    if(tts.length > index +1) {
      createClipsElement(clipsElem,index +1,tts)
    } else {
      $( '.ui-update-tts-enable-audio' ).removeClass( 'd-none' );
      //console.log('createClipsElement:totalDuration=<',totalDuration,'>');
      createLongClip();
    }
    */
  });
}

let longBuffer = false;
function createLongClip() {
  console.log('createLongClip:totalAudioBuffer=<',totalAudioBuffer,'>');
  console.log('createLongClip:totalDuration=<',totalDuration,'>');
  let frameCount = totalAudioBuffer[0].sampleRate * totalDuration;
  longBuffer = audioCtx.createBuffer(totalAudioBuffer[0].numberOfChannels, frameCount, totalAudioBuffer[0].sampleRate);
  console.log('createLongClip:longBuffer=<',longBuffer,'>');
  for(let channel = 0 ; channel < longBuffer.numberOfChannels;channel++) {
    //let longBuffering = longBuffer.getChannelData(channel);
    let index = 0;
    for(let clipIndex = 0;clipIndex < totalAudioBuffer.length ;clipIndex++) {
      let clip = totalAudioBuffer[clipIndex]
      let clipBuffer = clip.getChannelData(channel);
      longBuffer.copyToChannel(clipBuffer,channel,index);
      index += clipBuffer.length;
    }
  }
}
function playLongClip() {
  if(longBuffer) {
    let source = audioCtx.createBufferSource();
    source.buffer = longBuffer;
    source.connect(audioCtx.destination);
    source.start();
  }
}


function onClickTTS(elem) {
  //console.log('onClickTTS:elem=<',elem,'>');
  let audioList = document.getElementsByClassName('ui-update-tts-one-clip');
  //console.log('onClickTTS:audioList=<',audioList,'>');
  let root = elem.parentElement.parentElement;
  console.log('onClickTTS:root=<',root,'>');
  let speed = parseFloat(root.getElementsByTagName('input')[0].value);
  //doPlayTTS(audioList,0,speed);
  playLongClip();
}

function doPlayTTS(playList,index,speed) {
  //console.log('doPlayTTS:playList=<',playList,'>');
  if(playList.length > index) {
    let audio = playList[index];
    audio.muted = false;
    console.log('doPlayTTS:audio=<',audio,'>');
    console.log('doPlayTTS:index=<',index,'>');
    console.log('doPlayTTS:audio.duration=<',audio.duration,'>');
    
    /*
    audio.index = index;
    audio.onended = function (evt){
      console.log('doPlayTTS:audio.onended evt=<',evt,'>');
      console.log('doPlayTTS:audio.onended evt.target.index=<',evt.target.index,'>');
      doPlayTTS(playList,evt.target.index + 1,speed);
    }
    */
    audio.playbackRate = speed;
    audio.play();
    
    let stop = audio.duration *1000 + 50;
    let timer = setInterval(function(){
      console.log('doPlayTTS:audio.currentTime <',audio.currentTime,'>');
      if(audio.currentTime >= audio.duration - 0.01) {
        clearInterval(timer);
        doPlayTTS(playList,index+1,speed);
      }
    },20);
    /*
    setTimeout(function(){
      doPlayTTS(playList,index+1,speed);
    },stop);
    */
    
  }
}
function stopPlayTTS(playList,index) {
  if(playList.length > index) {
    let audio = playList[index];
    audio.pause();
  }
}

</script>

-->

<script type="text/javascript">


let uriStorage = "wss://" + location.host + "/wator/storage";
let wsStorage = new WebSocket(uriStorage);
wsStorage.onopen = onStorageOpen_;
wsStorage.onmessage = onStorageMessage_;
wsStorage.onclose = onStorageClose_;
wsStorage.onerror = onStorageError_;

function onStorageOpen_(evt) {
  console.log('onStorageOpen_:evt=<',evt,'>');
  if(ttsCached) {
    setTimeout(function(){
      createTTS(ttsCached);
    },1);
  }
}
function onStorageMessage_(evt) {
  //console.log('onStorageMessage_:evt.data=<',evt.data,'>');
  let jsonMsg = JSON.parse(evt.data);
  console.log('onStorageMessage_:jsonMsg=<',jsonMsg,'>');
  if(jsonMsg.result && jsonMsg.result.data) {
    onRecieveClipData(jsonMsg.result.data);
  }
}
function onStorageClose_(evt) {
  console.log('onStorageClose_:evt=<',evt,'>');
}
function onStorageError_(evt) {
  console.log('onStorageError_:evt=<',evt,'>');
}

let ttsCached = false;

function createTTS(tts) {
  console.log('createTTS:tts=<',tts,'>');
  console.log('createTTS:wsStorage=<',wsStorage,'>');
  if(wsStorage.readyState) {
    let clipsElem = document.getElementById('ui-update-tts-all-clips');
    //console.log('onClickTTS:clipsElem=<',clipsElem,'>');
    if(tts.length > 0){
      createClipsAudio(0,tts);
    }
  } else {
    ttsCached = tts;
  }
}



let AudioContext = window.AudioContext || window.webkitAudioContext;
let audioCtx = new AudioContext();



let totalAudioBuffer = [];
let totalDuration = 0;

let gTTS = false;
let gIndex = false;

function createClipsAudio(index,tts) {
  let clip = tts[index];
  console.log('createClipsElement:clip=<',clip,'>');
  let fetchClip = {tts:{download:clip}};
  console.log('createClipsElement:fetchClip=<',fetchClip,'>');
  gTTS = tts;
  gIndex = index;
  wsStorage.send(JSON.stringify(fetchClip));
  
  /*
  ipfs.files.cat(clip,function(err, file){
    if (err) {
      throw err;
    }
    console.log('createClipsElement:: ipfs.files.cat file=<',file,'>');
    audioCtx.decodeAudioData(file.buffer, function(decodedData) {
      //console.log('createClipsElement decodedData=<',decodedData,'>');
      totalAudioBuffer.push(decodedData);
      totalDuration += decodedData.duration;
      if(tts.length > index +1) {
        createClipsElement(clipsElem,index +1,tts)
      } else {
        $( '.ui-update-tts-enable-audio' ).removeClass( 'd-none' );
        //console.log('createClipsElement:totalDuration=<',totalDuration,'>');
        createLongClip();
      }
    });    
  });
  */
}

function onRecieveClipData(file) {
  console.log('onRecieveClipData:: file=<',file,'>');
  let encodedData = new Uint8Array(file);
  console.log('onRecieveClipData:: encodedData=<',encodedData,'>');
  //let encodedData = new ArrayBuffer(file);
  //console.log('onRecieveClipData:: encodedData=<',encodedData,'>');
  audioCtx.decodeAudioData(encodedData.buffer, function(decodedData) {
    //console.log('createClipsElement decodedData=<',decodedData,'>');
    totalAudioBuffer.push(decodedData);
    totalDuration += decodedData.duration;
    if(gTTS.length > gIndex +1) {
      createClipsAudio(gIndex +1,gTTS)
    } else {
      $( '.ui-update-tts-enable-audio' ).removeClass( 'd-none' );
      console.log('createClipsElement:totalDuration=<',totalDuration,'>');
      createLongClip();
    }
  });    
}


</script>
