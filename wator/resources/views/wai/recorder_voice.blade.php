@extends('wator.app')


@section('appnavbar')
  @include('wai.navbar')
@endsection

@section('content')

<!--
<div class="row justify-content-center">
  <div class="col-lg-10 ">
    <form action="#" method="post" enctype="multipart/form-data">
      {{ csrf_field() }}
      <input type="text" name="phoneme" id="upload-form-phoneme">
      <input type="text" name="token" id="upload-form-token">
      <input type="file" name="audio" id="upload-form-audio">
      <input type="submit" value="Upload Image" name="submit">
    </form>
  </div>
</div>
-->


<!--
<div class="row justify-content-center">
  <div class="col-lg-10 ">
    <div class="card card-default">
      <div class="card-header text-center">
        {{ trans('wai_record_voice.pinyin') }}
      </div>
      <div class="card-body">
      </div>
    </div>
  </div>
</div>
-->

<!--

<div class="row justify-content-center">
  <div class="col-lg-10 ">
    <div class="card card-default">
      <div class="card-header text-center">
        {{ trans('wai_record_voice.hirakana') }}
      </div>
      <div class="card-body">
        <div class="row justify-content-center">
          <div class="col">
            @include('wai.ja_phoneme',['phoneme' => 'あ'])
          </div>
          <div class="col">
            @include('wai.ja_phoneme',['phoneme' => 'い'])
          </div>
          <div class="col">
            @include('wai.ja_phoneme',['phoneme' => 'う'])
          </div>
          <div class="col">
            @include('wai.ja_phoneme',['phoneme' => 'え'])
          </div>
          <div class="col">
            @include('wai.ja_phoneme',['phoneme' => 'お'])
          </div>
        </div>

        <div class="row justify-content-center">
          <div class="col">
            @include('wai.ja_phoneme',['phoneme' => 'か'])
          </div>
          <div class="col">
            @include('wai.ja_phoneme',['phoneme' => 'き'])
          </div>
          <div class="col">
            @include('wai.ja_phoneme',['phoneme' => 'く'])
          </div>
          <div class="col">
            @include('wai.ja_phoneme',['phoneme' => 'け'])
          </div>
          <div class="col">
            @include('wai.ja_phoneme',['phoneme' => 'こ'])
          </div>
        </div>

        <div class="row justify-content-center">
          <div class="col">
            @include('wai.ja_phoneme',['phoneme' => 'が'])
          </div>
          <div class="col">
            @include('wai.ja_phoneme',['phoneme' => 'ぎ'])
          </div>
          <div class="col">
            @include('wai.ja_phoneme',['phoneme' => 'ぐ'])
          </div>
          <div class="col">
            @include('wai.ja_phoneme',['phoneme' => 'げ'])
          </div>
          <div class="col">
            @include('wai.ja_phoneme',['phoneme' => 'ご'])
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

-->


<div class="row justify-content-center">
  <div class="col-lg-10 ">
    <div class="card card-default">
      <div class="card-header text-center">
        {{ trans('wai_record_voice.hirakana') }}
      </div>
      <div class="card-body">
        <div class="row justify-content-center">
          <div class="col">
            @include('wai.ja_phoneme',['phoneme' => 'あ'])
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="row justify-content-center">
  <div class="col-lg-10 ">
  </div>
</div>



<script src="https://unpkg.com/ipfs-api@9.0.0/dist/index.js" integrity="sha384-5bXRcW9kyxxnSMbOoHzraqa7Z0PQWIao+cgeg327zit1hz5LZCEbIMx/LWKPReuB" crossorigin="anonymous"></script>

<script src="/wator/wai/notify.js" type="text/javascript"></script>
<script src="/wator/wai/upload.js" type="text/javascript"></script>
<!--
<script src="/wator/wai/record.js" type="text/javascript"></script>
-->

<script type="text/javascript">

function onUpdateData(msg) {
  console.log('onUpdateData:msg=<',msg,'>');
}
function onClickRecordBtn(elem) {
  console.log('onClickRecordBtn:elem=<',elem,'>');
  let root = elem.parentElement.parentElement;
  //console.log('onClickRecordBtn:root=<',root,'>');
  let phoneme = root.getElementsByTagName('h4')[0].textContent;
  console.log('onClickRecordBtn:phoneme=<',phoneme,'>');
  doAudioRecord(phoneme);
}

function doAudioRecord(phoneme) {
  console.log('doAudioRecord:phoneme=<',phoneme,'>');
  let mediaConstraints = { audio: true};
  navigator.getUserMedia(mediaConstraints, function(stream) {
      onMediaSuccess(stream,phoneme);
    }, onMediaError);
}
function onMediaSuccess(stream,phoneme) {
  let mr = new MediaRecorder(stream);
  mr.mimeType = 'audio/webm'; // audio/webm or audio/ogg or audio/wav
  let chunks = {};
  let clipIndex = 0;
  mr.ondataavailable = function (e) {
    //console.log('ondataavailable:e=<',e,'>');
    //console.log('ondataavailable:phoneme=<',phoneme,'>');
    //console.log('ondataavailable:window.URL=<',window.URL,'>');
    chunks[clipIndex++] = e.data;
   //saveToFile(chunks,phoneme);
   //uploadSlice(chunks,phoneme);
  }
  mr.onerror = function (e) {
    console.log('error:e=<',e,'>');
  }
  mr.onstart = function (e) {
    console.log('onstart:e=<',e,'>');
  }
  mr.onstop = function (e) {
    console.log('onstop:e=<',e,'>');
    console.log('onstop:chunks=<',chunks,'>');
  }
  mr.start(100);
  setTimeout(function(){
    mr.stop();
  },3000);
}
function onMediaError(e) {
  console.error('media error e=<', e,'>');
}

</script>


@endsection
