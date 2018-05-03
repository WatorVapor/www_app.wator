class WaiAudioRaw extends AudioWorkletProcessor {
  constructor() {
    super();
    this.buffer = [];
  }

  process(inputs, outputs) {
    console.log('WaiAudioRaw:process inputs=<',inputs,'>');
    let input = inputs[0];
    this.buffer.push(...input);
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
