@extends('wator.app')
@section('appnavbar')
  @include('starbian.navbar')
@endsection

@section('content')
<hr/>
<div class="row mt-lg-5 justify-content-center">
  <div class="col-5">
    <video id="video" autoplay width="640" height="480"></video>
  </div>
</div>




<script type="text/javascript">
  new Clipboard('.btn-clipboard');
</script>


@include('starbian.js.keys')
@include('starbian.js.videocam_r')
@endsection
