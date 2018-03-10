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
      <pre class="text-justify justify-content-center bg-warning" >
        <h4 id="ui-update-all-words" style="white-space:pre-wrap;"></h4>
      </pre>
    </div>
    <div class="row justify-content-center">
      <audio class="d-none" id="ui-update-tts-audio">
      </audio>
      <div class="d-none" id="ui-update-tts-all-clips">
      </div>
      <button type="submit" class="btn btn-lg btn-outline-dark rounded-circle" style="height:96px;width:96px;" onclick="onClickTTS(this)">
        <i class="material-icons " style="font-size:60px;color:green;">volume_up</i>
      </button>
    </div>
  </div>
</div>

<div class="row justify-content-center">
  <div class="col-lg-10" id="ui-update-graph">
    @foreach ($result as $sentence)
    <div class="card card-default text-center border border-danger">
      <div class="card-body">
        <h4 class="card-title">{{ $sentence['sentence'] }}</h4>
        <img class="card-img-bottom" src="{{ $sentence['graph'] }}.svg" alt="Card image cap">
      </div>
      <div class="card-footer">
        <a href="{{ $sentence['graph'] }}.svg" target="_blank" class="btn btn-primary">{{ trans('wai_participle.opengraph') }}</a>
        <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.wator.xyz/{{ $sentence['graph'] }}.png" target="_blank" class="btn btn-primary">{{ trans('wai_participle.facebook') }}</a>
      </div>
    </div>
    @endforeach
  </div>
</div>



<div class="d-none" id="ui-update-opengraph">{{ trans('wai_participle.opengraph') }}</div>
<div class="d-none" id="ui-update-facebook">{{ trans('wai_participle.facebook') }}</div>


<script src="/wator/wai/notify.js" type="text/javascript"></script>

@include('wai.js.participle_graph')
@include('wai.js.participle_tts')

@endsection
