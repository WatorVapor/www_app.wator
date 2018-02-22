@extends('wator.app')


@section('appnavbar')
  @include('wai.navbar')
@endsection

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/css/bootstrap-slider.css" integrity="sha256-qkeO+BtgpANRnm6UfrclSLyB+QdfOK4qtspUK6qpnGk=" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/bootstrap-slider.js" integrity="sha256-CMbY8O/nsUqZQgyh7wMVktFXm31lLdWlCkl86V2eSCg=" crossorigin="anonymous"></script>


<div class="row justify-content-center">
  <div class="col-lg-10 ">
    <div class="row">
      <div class="col">
        <button type="submit" class="btn btn-block " href="/wai/text/record_voice/cn">
          {{ trans('wai_record_voice.chinese') }}
        </button>
      </div>
      <div class="col">
        <button type="submit" class="btn btn-block " href="/wai/text/record_voice/ja">
          {{ trans('wai_record_voice.japanese') }}
        </button>
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
            @include('wai.phoneme',['phoneme' => 'あ','phoneme_help' => '阿'])
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

@include('wai.recode_code')


@endsection
