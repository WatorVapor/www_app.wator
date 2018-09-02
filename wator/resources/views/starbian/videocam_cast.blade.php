@extends('wator.app')
@section('appnavbar')
  @include('starbian.navbar')
@endsection

@section('content')

<div class="row mt-lg-5 justify-content-center">
  <div class="col-1">
    <a type="button" class="btn btn-success btn-block" onclick="onTestDeviceKey(this)">
      <i class="material-icons">remove_circle</i>
    </a>
  </div>
  <div class="col-5">
    <video id="video" autoplay controls width="640" height="480"></video>
  </div>
</div>

<script src="//webrtc.github.io/adapter/adapter-latest.js"></script>

@include('starbian.js.starbian')
@include('starbian.js.starbian_rtc')
@include('starbian.js.videocam_cast')
@endsection
