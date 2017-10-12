@extends('wator.app')
@section('appnavbar')
  @include('ppio.navbar')
@endsection

@section('content')
<div class="row">
  <div class="col-2 mt-lg-5">
    <button type="button" class="btn btn-success btn-lg btn-block" onclick="onBLESearch(this)">Search</button>
  </div>
</div>

<script src="/wator/ppio/js/ble.web.js" type="text/javascript"></script>

<script type="text/javascript">
  function onBLESearch(element) {
    runBLESource();
  }
</script>
@endsection
