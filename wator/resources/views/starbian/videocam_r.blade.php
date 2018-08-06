@extends('wator.app')
@section('appnavbar')
  @include('starbian.navbar')
@endsection

@section('content')
<hr/>
<div class="row mt-lg-5 justify-content-center">
  <div class="col-5">
    <div class="card card-default text-center bg-secondary">
      <div class="card-header">
        My Public key
      </div>
      <div class="card-body">
        <pre class="card-text text-danger" id="text-this-device-key" rows="40" style="white-space: pre-wrap ;">@{{ pub_key }}</pre>
        <br/>
        <button type="button" class="btn btn-primary btn-sm  pull-right btn-clipboard" id="btn-copy-key" data-clipboard-target="#text-this-device-key">Copy</button>
      </div>
    </div>
  </div>
</div>




<script type="text/javascript">
  new Clipboard('.btn-clipboard');
</script>

@include('starbian.js.videocam_r')
@endsection
