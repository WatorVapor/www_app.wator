<script type="text/javascript">

class IpfsTTS {
  constructor(baseDuration) {
    this.ttsStorage = new IpfsStorage(); 
    this.readyState = false;
    this.ttsCached = false;
    this.ttsCB = false;
    this.baseDuration = baseDuration;
    this.gTTS = false;
    this.gIndex = false;
    this.totalAudioBuffer = [];
    this.totalDuration = 0;
    this.longBuffer = false;
    this.audioCtx = new AudioContext();

    
    
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
    //console.log('creatAudioBufferByIPFSClips:tts=<',tts,'>');
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
      let source = this.audioCtx.createBufferSource();
      source.buffer = this.longBuffer;
      source.playbackRate.value = speed;
      source.connect(this.audioCtx.destination);
      source.start();
    }
  }
  
  
  createClipsAudio_(index,tts) {
    let clip = tts[index];
    //console.log('createClipsAudio:clip=<',clip,'>');
    let fetchClip = {tts:{download:clip}};
    //console.log('createClipsAudio:fetchClip=<',fetchClip,'>');
    this.gTTS = tts;
    this.gIndex = index;
    this.ttsStorage.get(fetchClip); 
  }


  onRecieveClipData_(file) {
    //console.log('onRecieveClipData:: file=<',file,'>');
    let encodedData = new Uint8Array(file);
    //console.log('onRecieveClipData:: encodedData=<',encodedData,'>');
    //let encodedData = new ArrayBuffer(file);
    //console.log('onRecieveClipData:: encodedData=<',encodedData,'>');
    let self = this;
    this.audioCtx.decodeAudioData(encodedData.buffer, function(decodedData) {
      //console.log('createClipsElement decodedData=<',decodedData,'>');
      self.totalAudioBuffer.push(decodedData);
      if(decodedData.duration > self.baseDuration) {
        self.totalDuration += self.baseDuration;
      } else {
        self.totalDuration += decodedData.duration;
      }
      if(self.gTTS.length > self.gIndex +1) {
        self.createClipsAudio_(self.gIndex +1,self.gTTS)
      } else {
        self.createLongClip_();
      }
    });    
  }


  createLongClip_() {
    //console.log('createLongClip:totalAudioBuffer=<',this.totalAudioBuffer,'>');
    //console.log('createLongClip:totalDuration=<',this.totalDuration,'>');
    let frameCount = this.totalAudioBuffer[0].sampleRate * this.totalDuration;
    this.longBuffer = this.audioCtx.createBuffer(this.totalAudioBuffer[0].numberOfChannels, frameCount, this.totalAudioBuffer[0].sampleRate);
    //console.log('createLongClip:longBuffer=<',longBuffer,'>');
    for(let channel = 0 ; channel < this.longBuffer.numberOfChannels;channel++) {
      //let longBuffering = this.longBuffer.getChannelData(channel);
      let index = 0;
      for(let clipIndex = 0;clipIndex < this.totalAudioBuffer.length ;clipIndex++) {
        let clip = this.totalAudioBuffer[clipIndex];
        let clipBuffer = clip.getChannelData(channel);
        //console.log('createLongClip:clip=<',clip,'>');

        let baseLength  = this.baseDuration * clip.sampleRate;
        //console.log('createLongClip:baseLength=<',baseLength,'>');
        let cpLength = clipBuffer.length;
        if(clipBuffer.length > baseLength) {
          cpLength = baseLength;
        }
        //console.log('createLongClip:cpLength=<',cpLength,'>');

        let baseBuffer = new Float32Array(clipBuffer,0,cpLength);
        this.longBuffer.copyToChannel(baseBuffer,channel,index);
        index += cpLength;
      }
    }
    if(typeof this.ttsCB === 'function') {
      this.ttsCB(this.longBuffer);
    }
  }

};

</script>
