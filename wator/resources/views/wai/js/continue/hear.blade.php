@php
  $phonemesList = implode(',',$ipfs);
@endphp

<script type="text/javascript">

let hearingBuffer = false;
function onClickHearingBtn (elem) {
  console.log('onClickHearingBtn:elem=<',elem,'>');
}

$(document).ready(function(){
  createTTSBuffer();
});

function createTTSBuffer() {
  let phonemes = '{{ $phonemesList }}';
  console.log('createTTSBuffer:phonemes=<',phonemes,'>');
  let phonArr = phonemes.split(',');
  console.log('createTTSBuffer:phonArr=<',phonArr,'>');
  creatAudioBufferByIPFSClips(phonArr,function(buffer){
    console.log('createTTSBuffer:buffer=<',buffer,'>');
  });
}

</script>
