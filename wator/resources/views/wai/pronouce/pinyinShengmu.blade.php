@extends('wator.app')
@section('appnavbar')
  @include('wai.navbar')
@endsection
@section('content')
<div class="row justify-content-center">
  <div class="col-10 text-center mt-1">
    <h1>汉语标准拼音声母</h1>
  </div>
</div>
<hr/>
<div class="row justify-content-center"> 
  <div class="col-2">
    <div class="row justify-content-start">
      <div class="col-6 text-center mt-1">
        <h1>{{ $yinjie }}</h1>
      </div>
    </div>
    <div class="row justify-content-start">
      <div class="col-6 text-center mt-1">
        <audio class="d-none">
          <source id="ui-audio-standard-source" src="/wator/audio/zhpinyin/shengmu/{{ $yinjie }}.mp3" type="audio/mp3">
        </audio>
        <button type="button" class="btn btn-primary btn-lg" onclick="onUIClickPlayStandardPronounce(this)">
          <i class="material-icons md-48">hearing</i>
        </button>
      </div>
    </div>
    
    <div class="row justify-content-start mt-5">      
      <div class="col text-center mt-5">
        <button type="button" class="btn btn-primary btn-lg" onclick="onUIClickRecordPronounce(this)">
          <i class="material-icons md-48">settings_voice</i>
        </button>
      </div>
       <div class="col text-center mt-5">
        <button type="button" class="btn btn-primary btn-lg d-none" id="ui-audio-record-play" onclick="onUIClickPlayRecordPronounce(this)">
          <i class="material-icons md-48">play_arrow</i>
        </button>
      </div>
    </div>    
  </div>
  
  <div class="col-10">
    <div class="row justify-content-center mt-1">
      <div class="col text-center mt-1">
        <h5>标准波形</h5>
        <div id="standarddWaveform"></div>
      </div>
    </div>
    <div class="row justify-content-center mt-1 d-none">      
     <div class="col text-center mt-1">
        <div id="mineWaveform"></div>
        <h5>我的波形</h5>
      </div>
    </div>
    <div class="row justify-content-center mt-1">      
     <div class="col text-center mt-1">
        <div id="clipWaveform"></div>
        <h5>我的波形Clip</h5>
      </div>
    </div>

  </div>
</div>
<hr/>
<div class="row justify-content-center">
  @include('wai.pronouce.pinyin.shengmu')
</div>
@include('wai.pronouce.script')
@endsection

