@extends('wator.app')


@section('appnavbar')
  @include('wai.navbar')
@endsection

@section('content')

<div class="row justify-content-center">
  <div class="col-lg-10 ">
    <div class="card card-default">
      <div class="card-body">
        <form class="form-horizontal" method="POST" action="#" accept-charset="utf-8">
          {{ csrf_field() }}
          <div class="form-group">
            <div class="col-lg-12">
              <textarea class="form-control inputfield text" cols="50" rows ="5" placeholder="{{ trans('wai_participle.inputsentence') }}" name="sentence">{{ $text }}</textarea>
            </div>
          </div>
          <div class="form-group">
            <div class="row justify-content-center">
              <div class="col-lg-2">
                <button type="submit" value="cn" name="lang" class="btn btn-block btn-primary"> {{ trans('wai_participle.chinese') }} </button>
              </div>
              <div class="col-lg-2">
                <button type="submit" value="ja" name="lang" class="btn btn-block btn-success"> {{ trans('wai_participle.japanese') }} </button>
              </div>
            </div>
         </div>
        </form>
      </div>
    </div>
  </div>
</div>

@if ($process)
<div class="row justify-content-center ui-update-toggle">
@else
<div class="row justify-content-center ui-update-toggle d-none">
@endif
  <div class="col-lg-2">
    <i class="fa fa-spinner fa-spin" style="font-size:96px;color:red"></i>
  </div>
</div>

<hr/>

<div class="row justify-content-center ui-update-toggle d-none">
  <div class="col-lg-10 justify-content-center ">
    <div class="row justify-content-center">
      <a href="http://service.weibo.com/share/share.php?url=https://www.wator.xyz/wai/text/participle&appkey=4192536820&title=##text##" 
        target="_blank" class="btn btn-primary">
        {{ trans('wai_participle.weibo') }}
      </a>
    </div>
    <div class="row justify-content-center">
      <pre class="text-justify justify-content-center bg-warning" >
        <h4 id="ui-update-all-words" style="white-space:pre-wrap;">@{{ all-words }}</h4>
      </pre>
    </div>
    <div class="row justify-content-center">
      <div class="col d-none">
        <audio id="ui-update-tts-audio">
        </audio>
        <div id="ui-update-tts-all-clips">
        </div>
        <div id="ui-update-tts-all-clips">
        </div>
      </div>
      <div class="col-5">
      </div>
      <div class="col-1 justify-content-right d-none ui-update-tts-enable-audio">
        <div class="input-group">
          <span class="input-group-addon">Speed</span>
          <input id="msg" type="text" class="form-control" name="msg" value="1.1">
        </div>
      </div>
      <div class="col-6 justify-content-left d-none ui-update-tts-enable-audio">
        <button type="submit" class="btn btn-lg btn-outline-dark rounded-circle" style="height:96px;width:96px;" onclick="onClickTTS(this)">
          <i class="material-icons " style="font-size:60px;color:green;">volume_up</i>
        </button>
      </div>
    </div>
  </div>
</div>

<div class="row justify-content-center">
  <div class="col-lg-10" id="ui-update-graph">
  </div>
</div>



<div class="d-none" id="ui-update-opengraph">{{ trans('wai_participle.opengraph') }}</div>
<div class="d-none" id="ui-update-facebook">{{ trans('wai_participle.facebook') }}</div>
<div class="d-none" id="ui-update-weibo">{{ trans('wai_participle.weibo') }}</div>


<script src="/wator/wai/notify.js" type="text/javascript"></script>

@include('wai.js.participle_graph')
@include('wai.js.participle_tts')

@endsection
