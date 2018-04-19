<script type="text/javascript">
function splitPhonemeClips(audioCtx,source) {
  console.log('splitPhonemeClips source=<',source,'>');
  let jsProcess = audioCtx.createScriptProcessor(RawWindowSize, 1, 1);
  jsProcess.onaudioprocess = onRawAudioData;
  source.connect(jsProcess);
  jsProcess.connect(audioCtx.destination);
}
</script>
