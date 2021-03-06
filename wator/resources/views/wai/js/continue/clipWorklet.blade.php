<script type="text/javascript">

function splitPhonemeClips(audioCtx,source) {
  console.log('splitPhonemeClips source=<',source,'>');
  audioCtx.audioWorklet.addModule('/wator/wai/wai-audio-raw.js').then(() => {
    let recRawAudio = new AudioWorkletNode(audioCtx, 'wai-audio-raw');
    source.connect(recRawAudio);
    let filter100 = bandFilter(audioCtx,20,100,recRawAudio);
    let filter500 = bandFilter(audioCtx,80,500,recRawAudio);
    let filter1000 = bandFilter(audioCtx,480,1000,recRawAudio);
    let filter1500 = bandFilter(audioCtx,980,1500,recRawAudio);
    let filter2000 = bandFilter(audioCtx,1480,2000,recRawAudio);
    
    
    audioCtx.audioWorklet.addModule('/wator/wai/wai-audio-filter.js').then(() => {
      
      let waiAudioFilter100 = new AudioWorkletNode(audioCtx, 'wai-audio-filter');
      waiAudioFilter100.port.postMessage({sampleRate:audioCtx.sampleRate,limen:0.005});
      filter100.connect(waiAudioFilter100);      
      waiAudioFilter100.connect(audioCtx.destination);
      
      let waiAudioFilter500 = new AudioWorkletNode(audioCtx, 'wai-audio-filter');
      waiAudioFilter500.port.postMessage({sampleRate:audioCtx.sampleRate,limen:0.01});
      filter500.connect(waiAudioFilter500);      
      waiAudioFilter500.connect(audioCtx.destination);
      
      let waiAudioFilter1000 = new AudioWorkletNode(audioCtx, 'wai-audio-filter');
      waiAudioFilter1000.port.postMessage({sampleRate:audioCtx.sampleRate,limen:0.02});
      filter1000.connect(waiAudioFilter1000);      
      waiAudioFilter1000.connect(audioCtx.destination);

      let waiAudioFilter1500 = new AudioWorkletNode(audioCtx, 'wai-audio-filter');
      waiAudioFilter1500.port.postMessage({sampleRate:audioCtx.sampleRate,limen:0.03});
      filter1500.connect(waiAudioFilter1500);      
      waiAudioFilter1500.connect(audioCtx.destination);

      let waiAudioFilter2000 = new AudioWorkletNode(audioCtx, 'wai-audio-filter');
      waiAudioFilter2000.port.postMessage({sampleRate:audioCtx.sampleRate,limen:0.05});
      filter2000.connect(waiAudioFilter2000);      
      waiAudioFilter2000.connect(audioCtx.destination);


    });
  });
}


function bandFilter(audioCtx,freqFrom,freqTo,source){
  let filter = audioCtx.createBiquadFilter();
  filter.type = 'bandpass';
  let from = freqFrom;
  let to = freqTo;
  let geometricMean = Math.sqrt(from * to);
  filter.frequency.value = geometricMean;
  filter.Q.value = geometricMean / (to - from);
  source.connect(filter);
  return filter;
}

</script>
