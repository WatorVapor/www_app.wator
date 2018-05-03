const RawWindowSize = 16384;
const RawConvSize = 16384/2;
const dAvarageEnergyMin = 0.02;


class WaiAudioRaw extends AudioWorkletProcessor {
  constructor() {
    super();
    this.buffer = [];
  }
  process(inputs, outputs) {
    //console.log('WaiAudioRaw:process inputs=<',inputs,'>');
    let input = inputs[0][0];
    //console.log('WaiAudioRaw:process input=<',input,'>');
    this.buffer.push(...input);
    //console.log('WaiAudioRaw:process this.buffer.length=<',this.buffer.length,'>');
    if(this.buffer.length >= RawWindowSize) {
      //console.log('WaiAudioRaw:process this.buffer.length=<',this.buffer.length,'>');
      //console.log('WaiAudioRaw:process this.buffer=<',this.buffer,'>');
      if(isStongWave(this.buffer)) {
        console.log('WaiAudioRaw:process inputs=<',inputs,'>');
        console.log('createRecognition this=<',this,'>');
        createRecognition(this.buffer);
      }
      this.buffer.splice(0,RawConvSize);
    }
    return true;
  }
}
registerProcessor('wai-audio-raw', WaiAudioRaw);


function isStongWave(wave) {
  //console.log('isStongWave:wave=<',wave,'>');
  let energy = 0.0;
  for(let i = 0;i < wave.length ;i++) {
    let level = Math.abs(wave[i]);
    //console.log('isStongWave:level=<',level,'>');
    energy += level;
  }
  //console.log('isStongWave:energy=<',energy,'>');
  let avarageEnergy = energy/wave.length;
  //console.log('isStongWave:avarageEnergy=<',avarageEnergy,'>');
  if(avarageEnergy > dAvarageEnergyMin) {
    return true;
  }
  return false;
}

function createRecognition(buffer,ctx) {
  console.log('createRecognition buffer=<',buffer,'>');
  console.log('createRecognition ctx=<',ctx,'>');
}




