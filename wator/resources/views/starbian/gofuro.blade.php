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
  <div class="col-4">
    <div class="card card-default text-center bg-secondary">
      <div class="card-header">
        My Public key
      </div>
      <div class="card-body">
        <button type="button" class="btn btn-primary btn-sm  pull-right btn-clipboard" id="btn-copy-key" data-clipboard-target="#text-this-device-key">Copy</button>
        <pre class="card-text text-danger small" id="text-this-device-key" rows="40"></pre>
      </div>
    </div>
  </div>
  <div class="col-4">
    <div class="card card-default text-center bg-info">
      <div class="card-header">
        Go Furo Public key
      </div>
      <div class="card-body">
        <button type="button" class="btn btn-success btn-sm" id="btn-add-key" onclick="onAddRemoteKey(this)">+ Key for remote for GoFuRo</button>
        <textarea class="form-control input-sm" id="text-remote-device-key" rows="10" ></textarea>
      </div>
    </div>
  </div>
</div>


<script src="/wator/starbian/js/starbian.web.js" type="text/javascript"></script>

<script type="text/javascript">
  new Clipboard('.btn-clipboard');
</script>


<script type="text/javascript">
  var star = new StarBian();
  var channel = false;
  function onStartGoFuro(element) {
    console.log('element=<',element,'>');
    if(channel) {
      star.publish(channel,'gofuro hot');
    }
  }
  function onAddRemoteKey(element) {
    console.log('element=<',element,'>');
    var key = $('#text-remote-device-key').val();
    console.log('key=<',key,'>');
    star.addRemoteKey('gofuro',key);
  }
  $(document).ready(function() {
    var pubKeyStr = star.getPublic();
    $('#text-this-device-key').text(pubKeyStr);
    let remoteKey = star.getRemoteKey('gofuro');
    console.log('remoteKey=<',remoteKey,'>');
    if(remoteKey.length > 0) {
      $('#text-remote-device-key').text(remoteKey[0]);
      channel = star.getRemoteChannel(remoteKey[0]);
    }
  });
</script>
@endsection
