@php
  $phonemesList = json_encode($ipfs,JSON_UNESCAPED_UNICODE);
@endphp

<script type="text/javascript">
let phonemes = '{{ $phonemesList }}';
function onClickHearingBtn (elem) {
  console.log('onClickHearingBtn:elem=<',elem,'>');
  console.log('onClickHearingBtn:phonemes=<',phonemes,'>');
}
</script>
