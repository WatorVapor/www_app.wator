@extends('wator.app')


@section('appnavbar')
  @include('wai.navbar')
@endsection

@section('content')

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



<script src="https://unpkg.com/ipfs-api@9.0.0/dist/index.js" integrity="sha384-5bXRcW9kyxxnSMbOoHzraqa7Z0PQWIao+cgeg327zit1hz5LZCEbIMx/LWKPReuB" crossorigin="anonymous"></script>

<script src="/wator/wai/notify.js" type="text/javascript"></script>
<script src="/wator/wai/upload.js" type="text/javascript"></script>
<script src="/wator/wai/record.js" type="text/javascript"></script>

@endsection
