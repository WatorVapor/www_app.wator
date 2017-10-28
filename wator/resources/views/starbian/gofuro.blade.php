@extends('wator.app')
@section('appnavbar')
  @include('starbian.navbar')
@endsection

@section('content')
<div class="row mt-lg-5 justify-content-center">
  <div class="col-6">
    <button type="button" class="btn btn-success btn-lg btn-block" onclick="onStartGoFuro(this)">!!!HotUp!!!</button>
  </div>
</div>

<script src="/wator/starbian/js/starbian.web.js" type="text/javascript"></script>
<script type="text/javascript">
  var star = new StarBian();
  function onStartGoFuro(element) {
  }
</script>
@endsection
