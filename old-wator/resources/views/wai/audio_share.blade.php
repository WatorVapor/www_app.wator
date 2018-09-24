@extends('wator.app')
@section('content')
<div class="container-fluid">
<!--
  <div class="row">
    <div class="col-md-2 col-md-offset-5">
      <div class="alert alert-danger alert-dismissable">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <strong>Danger!</strong> This alert box could indicate a dangerous or potentially negative action.
      </div>
    </div>
  </div>
-->
  <div class="row">
    <div class="col-md-2 col-md-offset-4">
      <button type="button" class="btn btn-success btn-lg btn-block" onClick="onStartShareBtn(this)">Share Audio.</button>
    </div>
    <div class="col-md-2 ">
      <button type="button" class="btn btn-success btn-lg btn-block" onClick="onStopShareBtn(this)">Stop Audio.</button>
    </div>
  </div>
</div>
<script type="text/javascript">
  var recorder = null;
  var recordedBlobs = [];
  function onStartShareBtn(elem) {
    console.log(elem);
    navigator.mediaDevices.getUserMedia({video:false,audio:true}
    ).then(function (stream) { // success
      console.log(stream);
      createMediaRecorder(stream);
    }).catch(function (error) { // error
      console.error(error);
    });
  }
  function onStopShareBtn(elem) {
    console.log(elem);
    if(recorder) {
      recorder.stop();
      recorder = null;
    }
  }
  function createMediaRecorder(stream) {
    var option = {
     mimeType : 'audio/webm'
    };
    recorder = new MediaRecorder(stream,option);
    recorder.ondataavailable = function(evt) {
      console.log(evt);
      recordedBlobs.push(evt.data);
    };
    recordedBlobs = [];
    recorder.start(1000);
    console.log(recorder);
    recorder.onstop = function(evt) {
      console.log(evt);
      recorder = null;
      saveRecordFile();
    };
  }
  function saveRecordFile(){
    var blob = new Blob(recordedBlobs, {type: 'audio/webm'});
    var url = window.URL.createObjectURL(blob);
    var a = document.createElement('a');
    a.style.display = 'none';
    a.href = url;
    a.download = 'test.webm';
    document.body.appendChild(a);
    a.click();
    console.log('test.webm');
    setTimeout(function() {
      document.body.removeChild(a);
      window.URL.revokeObjectURL(url);
    }, 100);
  }
</script>
@endsection
