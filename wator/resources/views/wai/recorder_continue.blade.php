@extends('wator.app')


@section('appnavbar')
  @include('wai.navbar')
@endsection

@section('content')

<div class="row justify-content-center">
  <div class="col-lg-10 ">
    <div class="row">
      <div class="col">
        <a class="btn btn-lg btn btn-primary btn-block" href="/wai/text/record_continue/cn" role="button">
          {{ trans('wai_record_voice.chinese') }}
        </a>
      </div>
      <div class="col">
        <a class="btn btn-lg btn btn-primary btn-block" href="/wai/text/record_continue/ja" role="button">
          {{ trans('wai_record_voice.japanese') }}
        </a>
      </div>
      <div class="col">
        <a class="btn btn-lg btn btn-primary btn-block" href="/wai/text/record_continue/ctrl" role="button">
          {{ trans('wai_record_voice.ctrl') }}
        </a>
      </div>
    </div>
  </div>
</div>

<hr/>

<div class="row justify-content-center">
  <div class="col-lg-10 ">
    <div class="card card-default">
      <div class="card-header text-center">
        {{ trans('wai_record_voice.train') }}
      </div>
      <div class="card-body">
        <div class="row justify-content-center">
          <div class="col">
            @include('wai.phoneme')
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





@include('wai.js.recoder')
@include('wai.js.chart')
@include('wai.js.clip')
@include('wai.js.misc')
@include('wai.js.ws_upload')

<script src="/wator/wai/notify.js" type="text/javascript"></script>

@endsection
