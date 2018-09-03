@extends('wator.app')
@section('appnavbar')
  @include('starbian.navbar')
@endsection

@section('content')

<div class="row justify-content-center">
  <a class="btn btn-primary" data-toggle="collapse" href="#collapse_setting_device" role="button" aria-expanded="false" aria-controls="collapse_setting_device">
    Setting of Camera & Micphone Devices
  </a>
</div>

<div class="collapse" id="collapse_setting_device">
  <div class="row justify-content-center">
    <div class="col-4" id="vue-ui-camera-devices">
      <div class="row mt-lg-5" v-for="camera in allCamera">
        <a class="btn btn-success btn-block" type="button" name="camera" onclick="onClickCameraTest(this)">
          @{{camera.name}}
          <p class="d-none">@{{camera.id}}</p>
        </a>
      </div>
    </div>
    <div class="col-4 ml-lg-5" id="vue-ui-mic-devices">
      <div class="row mt-lg-5" v-for="mic in allMic">
        <a class="btn btn-success btn-block" type="button" name="mic" onclick="onClickMicTest(this)">
           @{{mic.name}}
          <p class="d-none">@{{mic.id}}</p>
        </a>
      </div>
    </div>
  </div>

  <div class="row mt-lg-5 justify-content-center">
    <div class="col-5">
      <video id="video" autoplay controls width="320" height="240"></video>
    </div>
  </div>
</div>

<script src="//webrtc.github.io/adapter/adapter-latest.js"></script>

@include('starbian.js.starbian')
@include('starbian.js.starbian_rtc')
@include('starbian.js.videocam_cast')

<script type="text/javascript">
  DeviceSetting.getDevice( (devices) => {
    console.log('DeviceSetting.getDevice :devices=<',devices,'>');
    let mic = [];
    let camera = [];
    for(let i = 0;i < devices.length;i++) {
      let device = devices[i];
      console.log('DeviceSetting.getDevice :device=<',device,'>');
      let name = device.label;
      if(!name) {
        name = device.deviceId;
      }
      if(name.length > 32) {
        name = name.slice(0,32);
      }
      let deviceUI = {
        name:name,
        id:device.deviceId
        };
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
<script type="text/javascript">
  let config = {
    audio:{},
    video:{}
  }; 
  function onClickCameraTest(elem) {
    let mediaTag = document.getElementById('video');
    mediaTag.pause();
    mediaTag.srcObject = null;

    console.log('onClickCameraTest :elem=<',elem,'>');
    let idElem = elem.getElementsByTagName('p')[0];
    console.log('onClickCameraTest idElem=<' , idElem , '>');
    if(idElem) {
      let id = idElem.textContent;
      if(id) {
        config.video.deviceId = id.trim();
        DeviceSetting.getStream(config,onTestStream);
      }
    }
  }
  function onClickMicTest(elem) {
    let mediaTag = document.getElementById('video');
    mediaTag.stop();
    mediaTag.srcObject = null;

    console.log('onClickCameraTest :elem=<',elem,'>');
    let idElem = elem.getElementsByTagName('p')[0];
    console.log('onClickCameraTest idElem=<' , idElem , '>');
    if(idElem) {
      let id = idElem.textContent;
      if(id) {
        config.audio.deviceId = id.trim();
        DeviceSetting.getStream(config,onTestStream);
      }
    }
  }
  function onTestStream(stream) {
    console.log('onTestStream :stream=<',stream,'>');
    let mediaTag = document.getElementById('video');
    mediaTag.srcObject = stream;
    mediaTag.play();
  }
</script>

@endsection
