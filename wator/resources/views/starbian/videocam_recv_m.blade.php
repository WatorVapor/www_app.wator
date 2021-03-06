@extends('wator.app_m')

@section('content')
<div class="row mt-lg-5 justify-content-center">
  <div class="col-6">
    <video id="video" autoplay controls width="640" height="480"></video>
  </div>
</div>

<div class="row mt-lg-5 justify-content-center">
  <div class="col-5">
    <a type="button" class="btn btn-danger btn-lg btn-block" onclick="onRestartRemoteApp(this)">
      <i class="material-icons">remove_circle</i>
    </a>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/6.4.0/adapter.min.js" integrity="sha256-UH0Npcih7yj1s23pQK0UCrCSxx7AkT91CCMsUGnZ9Ew=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/1.0.9/push.min.js" integrity="sha256-7knTDMqjR962XOHsW7AEJpNDYQpsXXnCItzuekBvHqc=" crossorigin="anonymous"></script>
<script src="/wator/starbian/js/starbian.js" type="text/javascript"></script>
<script src="/wator/starbian/js/starbian_rtc.js" type="text/javascript"></script>
@include('starbian.js.videocam_recv')
@include('starbian.js.m_localstorage')
@include('starbian.js.starbian_tts')

@endsection
