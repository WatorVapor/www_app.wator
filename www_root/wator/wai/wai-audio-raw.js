
class WaiAudioRaw extends AudioWorkletProcessor {
  constructor() {
    super();
    this.buffer = [];
  }
  process(inputs, outputs) {
    //console.log('WaiAudioRaw:process inputs=<',inputs,'>');
    this.buffer.push(...inputs[0]);
    console.log('WaiAudioRaw:process this.buffer.length=<',this.buffer.length,'>');
    return true;
  }
}




registerProcessor('wai-audio-raw', WaiAudioRaw);
