@extends('wator.app_m')

@section('content')
<div class="row mt-lg-5 justify-content-center">
  <div class="col-5">
    <video id="video" autoplay controls width="640" height="480"></video>
  </div>
</div>

<script src="//webrtc.github.io/adapter/adapter-latest.js"></script>
<script src="/wator/starbian/js/starbian.js" type="text/javascript"></script>
<script src="/wator/starbian/js/starbian_rtc.js" type="text/javascript"></script>
@include('starbian.js.videocam_recv')
@include('starbian.js.m_localstorage')
@include('starbian.js.starbian_tts')

@endsection
