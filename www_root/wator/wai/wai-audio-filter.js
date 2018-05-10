

class WaiAudioFilter extends AudioWorkletProcessor {
  constructor() {
    super();
    this.buffer = [];
    let self = this;
    this.port.onmessage = (event) => {
      console.log(event.data);
      self.sampleRate = event.data;
    };
  }
  process(inputs, outputs) {
    //console.log('WaiAudioRaw:process inputs=<',inputs,'>');
    //console.log('WaiAudioRaw:process outputs=<',outputs,'>');
    return true;
  }
}
registerProcessor('wai-audio-filter', WaiAudioFilter);
