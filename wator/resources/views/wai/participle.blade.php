@extends('wator.app')


@section('appnavbar')
  @include('wai.navbar')
@endsection

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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

<div class="row justify-content-center">
  <div class="col-lg-10">
    <i class="fa fa-spinner fa-spin" style="font-size:96px;color:red"></i>
  </div>
</div>


@php
$resultAll = "";
foreach ($result as $sentence) {
  $resultAll .= $sentence['sentence'];
  $resultAll .= '%';
}
@endphp
<div class="row justify-content-center">
  <div class="col-lg-10">
    <pre class="text-justify text-nowrap bg-warning">
      <h3>{{ $resultAll }}</h3>
    </pre>
  </div>
</div>

<div class="row justify-content-center">
  <div class="col-lg-10">
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

<script src="/wator/wai/notify.js" type="text/javascript"></script>

<script type="text/javascript">
  function onUpdateData(msg) {
    console.log('onUpdateData:msg=<',msg,'>');
  }
</script>

@endsection
