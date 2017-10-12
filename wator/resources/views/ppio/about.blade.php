@extends('wator.app')
@section('appnavbar')
  @include('ppio.navbar')
@endsection

@section('content')
<div class="row">
  <div class="col">
    <div class="card card-default">
      <div class="card-heading">
        <h6>Devices</h6>
      </div>
      <div class="card-body">
        <img src="/wator/images/ppio/SmartHome-WebRTC-IoT-Hub.png" class="img-thumbnail" alt="rsa gif" width="100%">
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card card-default">
      <div class="card-heading">
        <h6>Webrtc</h6>
      </div>
      <div class="card-body">
        <img src="/wator/images/ppio/webrtc-sample-image.png" class="img-thumbnail" alt="webrtc over rsa peer" width="100%">
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card card-default">
      <div class="card-heading">
        <h6>Webrtc Signal</h6>
      </div>
      <div class="card-body">
        <img src="/wator/images/ppio/webrtc-another-web-3-638.jpg" class="img-thumbnail" alt="signal" width="100%">
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col">
    <div class="card card-default">
      <div class="card-heading">
        <h6>RSA</h6>
      </div>
      <div class="card-body">
        <img src="/wator/images/ppio/eCCob.png" class="img-thumbnail" alt="rsa gif" width="100%">
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card card-default">
      <div class="card-heading">
        <h6>Web Bluetooth</h6>
      </div>
      <div class="card-body">
        <img src="/wator/images/ppio/Web-Bluetooth-1-768x454.jpg" class="img-thumbnail" alt="Web Bluetooth API" width="100%">
      </div>
    </div>
  </div>
</div>
@endsection
