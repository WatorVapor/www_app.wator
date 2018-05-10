

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
//    console.log('WaiAudioRaw:process inputs=<',inputs,'>');
//    console.log('WaiAudioRaw:process outputs=<',outputs,'>');
    for(let i = 0;i < outputs.length;i++) {
      for(let j = 0;j < outputs[i].length;j++) {
        //console.log('WaiAudioRaw:process inputs[i][j]=<',inputs[i][j],'>');
        for(let k = 0;k < outputs[i][j].length;k++) {
          outputs[i][j][k] = inputs[i][j][k];
        }
      }
    }
    return true;
  }
}
registerProcessor('wai-audio-filter', WaiAudioFilter);
