<script type="text/javascript">


const dMinDeltaRawFeqWave = 0.001;
const dMinDeltaLowFeqWave = 0.16;
const dMinDeltaMiddleFeqWave = 0.04;
const dMinDeltaHighFeqWave = 0.02;

let prevRawAudioBuffer = false;


const dAvarageEnergyMin = 0.1;

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
let filterCtx = new AudioContext();

function onRawAudioData(evt) {
  let audioBuffer = evt.inputBuffer;
  //console.log('onaudioprocess:evt=<',evt,'>');
  //console.log('onaudioprocess:audioBuffer=<',audioBuffer,'>');
  if(prevRawAudioBuffer) {
    let audioCtx = filterCtx;
    //console.log('onaudioprocess:audioCtx=<',audioCtx,'>');
    let frameCount = audioBuffer.length + prevRawAudioBuffer.length;
    let myArrayBuffer = audioCtx.createBuffer(audioBuffer.numberOfChannels, frameCount, audioCtx.sampleRate);
    
    let prevData = prevRawAudioBuffer.getChannelData(0);
    myArrayBuffer.copyToChannel(prevData,0,0);
    let data = audioBuffer.getChannelData(0);
    myArrayBuffer.copyToChannel(data,0,prevData.length);
    //console.log('onaudioprocess:myArrayBuffer=<',myArrayBuffer,'>');
    
    if(isStongWave(myArrayBuffer.getChannelData(0))) {
      let source = audioCtx.createBufferSource();
      source.buffer = myArrayBuffer;
      startDemuxFreqs(audioCtx,source);
      source.start();
      source.onended = function(evt) {
        console.log('onaudioprocess:onended evt=<',evt,'>');
        source.disconnect();
        stopDemuxFreqs();
      }
    }    
  }
  prevRawAudioBuffer = audioBuffer;
}


function splitPhonemeClips(audioCtx,source) {
  console.log('splitPhonemeClips source=<',source,'>');
  let jsProcess = audioCtx.createScriptProcessor(FilterWindowSize, 1, 1);
  jsProcess.onaudioprocess = onRawAudioData;
  source.connect(jsProcess);
  jsProcess.connect(audioCtx.destination);
}

let freqDemux = [];
function startDemuxFreqs(audioCtx,source) {

  let svgRaw = false;
  let svgLow = false;
  let svgMiddle = false;
  let svgHigh = false;

  let fRaw = new AudioFreqDemux(audioCtx,source,dMinDeltaLowFeqWave,function(audio,freqs,peaks){
    if(freqs.length > 5) {
      console.log('startDemuxFreqs fRaw freqs=<',freqs,'>');
    }
    svgRaw = createWavePolyline(200,0,audio,peaks,freqs);
    if(svgRaw && svgLow && svgMiddle && svgHigh) {
      saveAllSVG(200,4,svgRaw + svgLow + svgMiddle + svgHigh);
    }
  });
  freqDemux.push(fRaw);
  let fLow = new AudioFreqDemux(audioCtx,source,dMinDeltaLowFeqWave,function(audio,freqs,peaks){
    if(freqs.length > 5) {
      console.log('startDemuxFreqs fLow freqs=<',freqs,'>');
    }
    svgLow = createWavePolyline(200,200,audio,peaks,freqs);
    if(svgRaw && svgLow && svgMiddle && svgHigh) {
      saveAllSVG(200,4,svgRaw + svgLow + svgMiddle + svgHigh);
    }
  },50,500);
  freqDemux.push(fLow);
  let fMiddle = new AudioFreqDemux(audioCtx,source,dMinDeltaMiddleFeqWave,function(audio,freqs,peaks){
    if(freqs.length > 5) {
      console.log('startDemuxFreqs fMiddle freqs=<',freqs,'>');
    }
    svgMiddle = createWavePolyline(200,400,audio,peaks,freqs);
    if(svgRaw && svgLow && svgMiddle && svgHigh) {
      saveAllSVG(200,4,svgRaw + svgLow + svgMiddle + svgHigh);
    }
  },500,1000);
  freqDemux.push(fMiddle);
  let fHigh = new AudioFreqDemux(audioCtx,source,dMinDeltaHighFeqWave,function(audio,freqs,peaks){
    if(freqs.length > 5) {
      console.log('startDemuxFreqs fHigh freqs=<',freqs,'>');
    }
    svgHigh = createWavePolyline(200,600,audio,peaks,freqs);
    if(svgRaw && svgLow && svgMiddle && svgHigh) {
      saveAllSVG(200,4,svgRaw + svgLow + svgMiddle + svgHigh);
    }
  },1000,1600);
  
  freqDemux.push(fHigh);
}

function stopDemuxFreqs() {
  for(let index in freqDemux) {
    let demu = freqDemux[index];
    //console.log('stopDemuxFreqs demu=<',demu,'>');
    demu.end();
  }
  freqDemux = [];
}


function saveAllSVG(height,row,svgRows,width) {
  let svg = '<svg width="';
  svg += width ;
  svg += '" height="';
  svg += height * row;
  svg += '" xmlns="http://www.w3.org/2000/svg">';
  svg += '\n';
  svg += svgRows;
  svg += '</svg>';
  let blob = new Blob([svg], {type: "image/svg+xml;charset=utf-8"});
  let urlBlob = window.URL.createObjectURL(blob);
  console.log('createWaveSVG:urlBlob=<',urlBlob,'>');
  let img = document.getElementById('wai-recognition-wave');
  img.src = urlBlob;
  var a = document.createElement('a');
  a.href = urlBlob;
  a.download = 'wai.recog_fix.svg';
  a.click();
  svg = false;
  svgHigh = false;
  svgRaw = false;
}

function createWavePolyline(height,offsetY,wave,peaks,freqs) {
  let width = wave.length;
  //console.log('createWavePolyline:wave=<',wave,'>');
  let peak = height/2;
  
  let svg = '<polyline points="';
  for(let i = 0;i < wave.length ;i++) {
    let y = offsetY + peak - wave[i] * peak;
    let x = i;
    svg +=  ' ' + x  + ',' + y;
  }
  svg += '"';
  svg += '\n';
  svg += ' fill="none" stroke="red" stroke-width="1" />';
  svg += '<polyline points="';
  for(let i = 0;i < peaks.length ;i++) {
    let y = offsetY + peak - peaks[i][1] * peak;
    let x = peaks[i][0];
    svg +=  ' ' + x  + ',' + y;
  }
  svg += '"';
  svg += '\n';
  svg += ' fill="none" stroke="green" stroke-width="1" />';
/*
  for(let i = 0;i < peaks.length ;i++) {
    let y = peak - peaks[i][1] * peak;
    let x = peaks[i][0];
    svg += '<text font-size="1" x="';
    svg += x;
    svg += '" y="';
    svg += offsetY + y;
    svg += '">';
    svg += peaks[i][0] %100;
    svg +=  '</text>';
  }
*/
  let counter = 0;
  for(let i = 0;i < freqs.length ;i++) {
    let y = peak - freqs[i][2] * peak;
    if(y < 30) {
      y += 30;
    }
    if(y > height -30) {
      y -= 30;
    }
    y += offsetY;
    let x = freqs[i][0];
    svg += '<text font-size="12" x="';
    svg += x;
    svg += '" y="';
    svg += y;
    svg += '">';
    svg += freqs[i][1];
    svg +=  '</text>';
    svg += '\n';
 }
  
  
  let centerY = peak+offsetY;
  svg += '<polyline points="';
  svg += ' 0,' + centerY + ' ';
  svg += width +',' + centerY + ' ';
  svg += '"';
  svg += '\n';
  svg += ' fill="none" stroke="blue" stroke-width="1" />';
  svg += '\n';
  return svg;
}


</script>

