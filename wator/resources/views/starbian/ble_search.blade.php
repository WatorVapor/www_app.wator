@extends('wator.app')
@section('appnavbar')
  @include('starbian.navbar')
@endsection

@section('content')
<div class="row">
  <button type="button" class="btn btn-success btn-lg btn-block" onclick="onBLESearch(this)">Search</button>
</div>

<script src="/wator/starbian/js/ble.web.js" type="text/javascript"></script>
<script type="text/javascript">
  function onBLESearch(element) {
    runBLESource();
  }
</script>
@endsection
