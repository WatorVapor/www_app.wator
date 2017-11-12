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

@php
$resultAll = "";
foreach ($result as $sentence) {
  $resultAll .= $sentence['sentence'];
}
@endphp
<div class="row justify-content-center">
  <div class="col-lg-10">
    <h1 class="text-justify text-nowrap bg-warning">
       {{ $resultAll }}
    </h1>
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
      </div>
    </div>
    @endforeach
  </div>
</div>



@endsection
