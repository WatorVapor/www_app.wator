<script type="text/javascript">

class IpfsTTS {
  constructor() {
    this.ttsStorage = new IpfsStorage(); 
    this.readyState = false;
    this.ttsCached = false;
    this.ttsCB = false;
    this.baseDuration = 0.2;
    this.gTTS = false;
    this.gIndex = false;
    this.totalAudioBuffer = [];
    this.totalDuration = 0;
    this.longBuffer = false;

    
    
    let self = this;
    this.ttsStorage.onReady = function(){
      self.readyState = true;
      if(self.ttsCached) {
        self.creatAudioBufferByIPFSClips(self.ttsCached,self.ttsCB);
      }
    };
    this.ttsStorage.onStorage = function(clipData){
      //console.log('ttsStorage.onStorage:clipData=<',clipData,'>');
      self.onRecieveClipData_(clipData);
    };
  }
  
  creatAudioBufferByIPFSClips(tts,cb) {
    console.log('creatAudioBufferByIPFSClips:tts=<',tts,'>');
    this.ttsCB = cb;
    if(this.readyState) {
      if(tts.length > 0){
        this.createClipsAudio_(0,tts);
      }
    } else {
      this.ttsCached = tts;
    }
  }
  playLongClip(speed) {
    if(this.longBuffer) {
      let source = audioCtx.createBufferSource();
      source.buffer = this.longBuffer;
      source.playbackRate.value = speed;
      source.connect(audioCtx.destination);
      source.start();
    }
  }
  
  
  createClipsAudio_(index,tts) {
    let clip = tts[index];
    console.log('createClipsAudio:clip=<',clip,'>');
    let fetchClip = {tts:{download:clip}};
    console.log('createClipsAudio:fetchClip=<',fetchClip,'>');
    gTTS = tts;
    gIndex = index;
    ttsStorage.get(fetchClip); 
  }


  onRecieveClipData_(file) {
    //console.log('onRecieveClipData:: file=<',file,'>');
    let encodedData = new Uint8Array(file);
    //console.log('onRecieveClipData:: encodedData=<',encodedData,'>');
    //let encodedData = new ArrayBuffer(file);
    //console.log('onRecieveClipData:: encodedData=<',encodedData,'>');
    audioCtx.decodeAudioData(encodedData.buffer, function(decodedData) {
      //console.log('createClipsElement decodedData=<',decodedData,'>');
      totalAudioBuffer.push(decodedData);
      if(decodedData.duration > baseDuration) {
        totalDuration += baseDuration;
      } else {
        totalDuration += decodedData.duration;
      }
      if(gTTS.length > gIndex +1) {
        createClipsAudio(gIndex +1,gTTS)
      } else {
        createLongClip();
      }
    });    
  }


  createLongClip_() {
    //console.log('createLongClip:totalAudioBuffer=<',totalAudioBuffer,'>');
    //console.log('createLongClip:totalDuration=<',totalDuration,'>');
    let frameCount = totalAudioBuffer[0].sampleRate * totalDuration;
    longBuffer = audioCtx.createBuffer(totalAudioBuffer[0].numberOfChannels, frameCount, totalAudioBuffer[0].sampleRate);
    //console.log('createLongClip:longBuffer=<',longBuffer,'>');
    for(let channel = 0 ; channel < longBuffer.numberOfChannels;channel++) {
      //let longBuffering = longBuffer.getChannelData(channel);
      let index = 0;
      for(let clipIndex = 0;clipIndex < totalAudioBuffer.length ;clipIndex++) {
        let clip = totalAudioBuffer[clipIndex];
        let clipBuffer = clip.getChannelData(channel);
        //console.log('createLongClip:clipBuffer=<',clipBuffer,'>');

        let baseLength  = baseDuration * clip.sampleRate;
        //console.log('createLongClip:baseLength=<',baseLength,'>');
        let cpLength = clipBuffer.length;
        if(clipBuffer.length > baseLength) {
          cpLength = baseLength;
        }
        console.log('createLongClip:cpLength=<',cpLength,'>');

        let baseBuffer = new Float32Array(clipBuffer,0,cpLength);
        longBuffer.copyToChannel(baseBuffer,channel,index);
        index += cpLength;
      }
    }
    if(typeof ttsCB === 'function') {
      ttsCB(longBuffer);
    }
  }

};



let ttsStorage = new IpfsStorage(); 
let ttsStorageReadyState = false;
let ttsCached = false;
let ttsCB = false;

ttsStorage.onReady = function(evt) {
  console.log('ttsStorage.onReady:evt=<',evt,'>');
  ttsStorageReadyState = true;
  if(ttsCached) {
    setTimeout(function(){
      creatAudioBufferByIPFSClips(ttsCached,ttsCB);
    },1);
  }
}
ttsStorage.onStorage = function(clipData) {
  //console.log('ttsStorage.onStorage:clipData=<',clipData,'>');
  onRecieveClipData(clipData);
}



let baseDuration = 0.2;

function creatAudioBufferByIPFSClips(tts,cb) {
  console.log('creatAudioBufferByIPFSClips:tts=<',tts,'>');
  ttsCB = cb;
  if(ttsStorageReadyState) {
    if(tts.length > 0){
      createClipsAudio(0,tts);
    }
  } else {
    ttsCached = tts;
  }
}

let gTTS = false;
let gIndex = false;
function createClipsAudio(index,tts) {
  let clip = tts[index];
  console.log('createClipsAudio:clip=<',clip,'>');
  let fetchClip = {tts:{download:clip}};
  console.log('createClipsAudio:fetchClip=<',fetchClip,'>');
  gTTS = tts;
  gIndex = index;
  ttsStorage.get(fetchClip); 
}


let totalAudioBuffer = [];
let totalDuration = 0;

function onRecieveClipData(file) {
  //console.log('onRecieveClipData:: file=<',file,'>');
  let encodedData = new Uint8Array(file);
  //console.log('onRecieveClipData:: encodedData=<',encodedData,'>');
  //let encodedData = new ArrayBuffer(file);
  //console.log('onRecieveClipData:: encodedData=<',encodedData,'>');
  audioCtx.decodeAudioData(encodedData.buffer, function(decodedData) {
    //console.log('createClipsElement decodedData=<',decodedData,'>');
    totalAudioBuffer.push(decodedData);
    if(decodedData.duration > baseDuration) {
      totalDuration += baseDuration;
    } else {
      totalDuration += decodedData.duration;
    }
    if(gTTS.length > gIndex +1) {
      createClipsAudio(gIndex +1,gTTS)
    } else {
      createLongClip();
    }
  });    
}

let longBuffer = false;

function createLongClip() {
  //console.log('createLongClip:totalAudioBuffer=<',totalAudioBuffer,'>');
  //console.log('createLongClip:totalDuration=<',totalDuration,'>');
  let frameCount = totalAudioBuffer[0].sampleRate * totalDuration;
  longBuffer = audioCtx.createBuffer(totalAudioBuffer[0].numberOfChannels, frameCount, totalAudioBuffer[0].sampleRate);
  //console.log('createLongClip:longBuffer=<',longBuffer,'>');
  for(let channel = 0 ; channel < longBuffer.numberOfChannels;channel++) {
    //let longBuffering = longBuffer.getChannelData(channel);
    let index = 0;
    for(let clipIndex = 0;clipIndex < totalAudioBuffer.length ;clipIndex++) {
      let clip = totalAudioBuffer[clipIndex];
      let clipBuffer = clip.getChannelData(channel);
      //console.log('createLongClip:clipBuffer=<',clipBuffer,'>');
      
      let baseLength  = baseDuration * clip.sampleRate;
      //console.log('createLongClip:baseLength=<',baseLength,'>');
      let cpLength = clipBuffer.length;
      if(clipBuffer.length > baseLength) {
        cpLength = baseLength;
      }
      console.log('createLongClip:cpLength=<',cpLength,'>');
      
      let baseBuffer = new Float32Array(clipBuffer,0,cpLength);
      longBuffer.copyToChannel(baseBuffer,channel,index);
      index += cpLength;
    }
  }
  if(typeof ttsCB === 'function') {
    ttsCB(longBuffer);
  }
}

function playLongClip(speed) {
  if(longBuffer) {
    let source = audioCtx.createBufferSource();
    source.buffer = longBuffer;
    source.playbackRate.value = speed;
    source.connect(audioCtx.destination);
    source.start();
  }
}


</script>
