

class WaiAudioFilter extends AudioWorkletProcessor {
  constructor() {
    super();
    this.buffer = [];
    let self = this;
    this.port.onmessage = (event) => {
      console.log(event.data);
      self.param = event.data;
    };
  }
  process(inputs, outputs) {
    //console.log('WaiAudioRaw:process inputs=<',inputs,'>');
    //console.log('WaiAudioRaw:process outputs=<',outputs,'>');
    console.log('WaiAudioRaw:process this.param=<',this.param,'>');
    return true;
  }
}
registerProcessor('wai-audio-filter', WaiAudioFilter);
