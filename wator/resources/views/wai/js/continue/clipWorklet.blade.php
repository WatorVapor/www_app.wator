<script type="text/javascript">

function splitPhonemeClips(audioCtx,source) {
  console.log('splitPhonemeClips source=<',source,'>');
  audioCtx.audioWorklet.addModule('/wator/wai/wai-audio-raw.js').then(() => {
    let waiAudioRaw = new AudioWorkletNode(audioCtx, 'wai-audio-raw');
    source.connect(waiAudioRaw);
    waiAudioRaw.connect(audioCtx.destination);
  });
}
</script>
