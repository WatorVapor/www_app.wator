<script type="text/javascript">
let ttsStorage = new IpfsStorage(); 

ttsStorage.onReady = function(evt) {
  console.log('ttsStorage.onReady:evt=<',evt,'>');
}

function creatAudioBufferByIPFSClips(clips) {
  console.log('creatAudioBufferByIPFSClips:clips=<',clips,'>');
}
</script>
