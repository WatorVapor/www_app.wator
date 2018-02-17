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
    console.log('onClickRecordBtn:elem=<',elem,'>');
    let root = elem.parentElement.parentElement;
    console.log('onClickRecordBtn:root=<',root,'>');
  }
</script>

@endsection
