@extends('wator.app')
@section('content')
<div class="container">
  <div class="row">
    <button type="button" class="btn btn-success btn-lg btn-block" onclick="onBLESearch(this)">Search</button>
  </div>
</div>
<script src="/p2pio/js/ble.web.js" type="text/javascript"></script>

<script type="text/javascript">
  function onBLESearch(element) {
    runBLESource();
  }
</script>
@endsection
