const RawWindowSize = 16384;
const RawConvSize = 16384/2;


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
        console.log('WaiAudioRaw:process this.buffer=<',this.buffer,'>');
      }
      this.buffer.splice(0,RawConvSize);
    }
    return true;
  }
}


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



registerProcessor('wai-audio-raw', WaiAudioRaw);
