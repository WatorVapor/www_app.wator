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

<div class="row mt-lg-5 justify-content-center">
  <div class="col-6">
    <div class="card card-default text-center">
      <div class="card-header">
        my public key
      </div>
      <div class="card-body">
        <pre class="card-text"></pre>
      </div>
    </div>
  </div>
</div>


<script src="/wator/starbian/js/starbian.web.js" type="text/javascript"></script>
<script type="text/javascript">
  var star = new StarBian();
  function onStartGoFuro(element) {
    console.log('element=<',element,'>');
    star.publish('gofuro hot');
  }
</script>
@endsection
