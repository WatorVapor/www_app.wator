class WaiAudioRaw extends AudioWorkletProcessor {
  constructor() {
    super();
    //this.pro = new WaiAudioProcess();
  }

  process(inputs, outputs) {
    console.log('WaiAudioRaw:process inputs=<',inputs,'>');
    processRaw(inputs,outputs);
    //this.pro.process(inputs,outputs);
    /*
    let output = outputs[0];
    for (let channel = 0; channel < output.length; ++channel) {
      output[channel].set(input[channel]);
    }
    */
    return true;
  }
}

registerProcessor('wai-audio-raw', WaiAudioRaw);
