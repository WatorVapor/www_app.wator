@extends('wator.app')


@section('appnavbar')
  @include('wai.navbar')
@endsection

@section('content')

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

<div class="row justify-content-center">
  <div class="col-lg-10 ">
  </div>
</div>



<script src="/wator/wai/notify.js" type="text/javascript"></script>

<script type="text/javascript">
  function onUpdateData(msg) {
    console.log('onUpdateData:msg=<',msg,'>');
  }
  function onClickRecordBtn(elem) {
    //console.log('onClickRecordBtn:elem=<',elem,'>');
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
    mr.ondataavailable = function (e) {
      console.log('ondataavailable:e=<',e,'>');
      console.log('ondataavailable:phoneme=<',phoneme,'>');
      console.log('ondataavailable:window.URL=<',window.URL,'>');
      const blob = new Blob(e.data, { type: 'audio/webm' });
      let urlBlob = window.URL.createObjectURL(blob);
      console.log('ondataavailable:urlBlob=<',urlBlob,'>');
    }
    mr.start();
    setTimeout(function(){
      mr.stop();
    },5000);
  }
  function onMediaError(e) {
    console.error('media error e=<', e,'>');
  }
  
</script>

@endsection
