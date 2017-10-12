@extends('wator.app')
@section('appnavbar')
  @include('ppio.navbar')
@endsection

@section('content')
<div class="row">
  <button type="button" class="btn btn-success btn-lg btn-block" onclick="onStartGoFuro(this)">Search</button>
</div>

<script src="/p2pio/js/ppio.web.js" type="text/javascript"></script>
<script type="text/javascript">
  function onStartGoFuro(element) {
  }
</script>
@endsection
