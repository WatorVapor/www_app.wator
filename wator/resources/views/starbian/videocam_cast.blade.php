@extends('wator.app')
@section('appnavbar')
  @include('starbian.navbar')
@endsection

@section('content')

<div class="row mt-lg-5 justify-content-center">
  <div class="col-2">
    <div class="form-check" v-for="camera in allCamera">
      <input class="form-check-input" type="radio" v-bind:value="camera.name">
      <label class="form-check-label" >
        @{{camera.name}}
      </label>
    </div>
  </div>
  <div class="col-5">
    <video id="video" autoplay controls width="320" height="240"></video>
  </div>
</div>

<script src="//webrtc.github.io/adapter/adapter-latest.js"></script>

@include('starbian.js.starbian')
@include('starbian.js.starbian_rtc')
@include('starbian.js.videocam_cast')
@endsection
