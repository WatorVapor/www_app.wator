@extends('wator.app')
@section('appnavbar')
  @include('starbian.navbar')
@endsection

@section('content')

<div class="row mt-lg-5 justify-content-center">
  <div class="col-2" id="vue-ui-camera-devices">
    <div class="form-check" v-for="camera in allCamera">
      <input class="form-check-input" type="radio" name="camera" v-bind:value="camera.name">
      <label class="form-check-label" >
        @{{camera.name}}
      </label>
    </div>
  </div>
  <div class="col-2" id="vue-ui-mic-devices">
    <div class="form-check" v-for="mic in allMic">
      <input class="form-check-input" type="radio" name="mic" v-bind:value="mic.name">
      <label class="form-check-label" >
        @{{mic.name}}
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

<script type="text/javascript">
  StarBianRtc.getDevice( (devices) => {
    console.log('StarBianRtc.getDevice :devices=<',devices,'>');
    let mic = [];
    let camera = [];
    for(let i = 0;i < devices.length;i++) {
      let device = devices[i];
      console.log('StarBianRtc.getDevice :device=<',device,'>');
      let name = device.label;
      if(!name) {
        name = device.deviceId;
      }
      let deviceUI = {name:name};
      if(device.kind === 'audioinput') {
        mic.push(deviceUI);
      }
      if(device.kind === 'videoinput') {
        camera.push(deviceUI);
      }
    }

    let cameraApp = new Vue({
      el: '#vue-ui-camera-devices',
      data: {
          allCamera: camera
      }
    });
    let audioApp = new Vue({
      el: '#vue-ui-mic-devices',
      data: {
          allMic: mic
      }
    });
  });

  
</script>
@endsection
