@extends('wator.app')
@section('appnavbar')
  @include('starbian.navbar')
@endsection

@section('content')

<div class="row mt-lg-5 justify-content-center">
  <div class="col-4" id="vue-ui-camera-devices">
    <div class="form-check" v-for="camera in allCamera">
      <input class="form-check-input" type="radio" name="camera" v-bind:value="camera.name" onChange="onClickCameraTest(this)">
      <label class="form-check-label" >
        @{{camera.name}}
      </label>
      <p class="d-none">@{{camera.id}}</p>
    </div>
  </div>
  <div class="col-4" id="vue-ui-mic-devices">
    <div class="form-check" v-for="mic in allMic">
      <input class="form-check-input" type="radio" name="mic" v-bind:value="mic.name" onChange="onClickMicTest(this)">
      <label class="form-check-label" >
        @{{mic.name}}
      </label>
      <p class="d-none">@{{mic.id}}</p>
    </div>
  </div>
</div>
<div class="row mt-lg-5 justify-content-center">
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
    console.log('onClickCameraTest :elem=<',elem,'>');
    let idElem = elem.parentElement.parentElement.getElementsByTagName('p')[0];
    console.log('onClickCameraTest idElem=<' , idElem , '>');
    if(idElem) {
      let id = idElem.textContent;
      if(id) {
        config.video.deviceId = id.trim();
        StarBianRtc.getStream(config,onTestStream);
      }
    }
  }
  function onClickMicTest(elem) {
    console.log('onClickCameraTest :elem=<',elem,'>');
    let idElem = elem.parentElement.parentElement.getElementsByTagName('p')[0];
    console.log('onClickCameraTest idElem=<' , idElem , '>');
    if(idElem) {
      let id = idElem.textContent;
      if(id) {
        config.audio.deviceId = id.trim();
        StarBianRtc.getStream(config,onTestStream);
      }
    }
  }
  function onTestStream(stream) {
    console.log('onTestStream :stream=<',stream,'>');
    let mediaTag = document.getElementById('video');
    mediaTag.src = URL.createObjectURL(stream);
    mediaTag.play();
  }
</script>

@endsection
