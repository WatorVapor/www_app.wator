const RawWindowSize = 16384;
const RawConvSize = 16384/2;


class WaiAudioRaw extends AudioWorkletProcessor {
  constructor() {
    super();
    this.buffer = [];
  }
  process(inputs, outputs) {
    console.log('WaiAudioRaw:process inputs=<',inputs,'>');
    this.buffer.push(...inputs[0]);
    //console.log('WaiAudioRaw:process this.buffer.length=<',this.buffer.length,'>');
    if(this.buffer.length >= RawWindowSize) {
      console.log('WaiAudioRaw:process this.buffer.length=<',this.buffer.length,'>');
      this.buffer.splice(0,RawConvSize);
    }
    return true;
  }
}




registerProcessor('wai-audio-raw', WaiAudioRaw);
