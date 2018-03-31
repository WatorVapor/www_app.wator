@php
  $phonemesList = implode(',',$ipfs);
@endphp

<script type="text/javascript">

let tts = let new IpfsTTS(0.2);
function onClickHearingBtn (elem) {
  console.log('onClickHearingBtn:elem=<',elem,'>');
  tts.playLongClip(1.1);
}

$(document).ready(function(){
  setTimeout(function(){
    createTTSBuffer();
  },1000);
});

function createTTSBuffer() {
  let phonemes = '{{ $phonemesList }}';
  //console.log('createTTSBuffer:phonemes=<',phonemes,'>');
  let phonArr = phonemes.split(',');
  //console.log('createTTSBuffer:phonArr=<',phonArr,'>');
  tts.creatAudioBufferByIPFSClips(phonArr,function(buffer){
    //console.log('createTTSBuffer:buffer=<',buffer,'>');
  });
}

</script>
