@php
  $phonemesList = implode(',',$ipfs);
@endphp

<script type="text/javascript">
let phonemes = '{{ $phonemesList }}';
function onClickHearingBtn (elem) {
  console.log('onClickHearingBtn:elem=<',elem,'>');
  console.log('onClickHearingBtn:phonemes=<',phonemes,'>');
  let phonArr = phonemes.split(',');
  console.log('onClickHearingBtn:phonArr=<',phonArr,'>');
}
</script>
