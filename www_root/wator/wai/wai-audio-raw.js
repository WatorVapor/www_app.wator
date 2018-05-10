const RawWindowSize = 16384;
const RawConvSize = 16384/2;
const dAvarageEnergyMin = 0.02;


class WaiAudioRaw extends AudioWorkletProcessor {
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
    console.log('WaiAudioRaw:process inputs=<',inputs,'>');
    console.log('WaiAudioRaw:process outputs=<',outputs,'>');
    return true;
  }
}
registerProcessor('wai-audio-raw', WaiAudioRaw);

