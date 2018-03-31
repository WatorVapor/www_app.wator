@php
  $phonemesList = json_encode($ipfs);
@endphp

<script type="text/javascript">
let phonemes = '{{ $phonemesList }}';
function onClickRecordBtn(elem) {
  console.log('onClickHearingBtn:elem=<',elem,'>');
  console.log('onClickHearingBtn:phonemes=<',phonemes,'>');
}
</script>
