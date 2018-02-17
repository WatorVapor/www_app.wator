@extends('wator.app')


@section('appnavbar')
  @include('wai.navbar')
@endsection

@section('content')


<div class="row justify-content-center">
  <div class="col-lg-5 ">
    <div class="card card-default">
      <div class="card-header text-center">
        {{ trans('wai_record_voice.pinyin') }}
      </div>
      <div class="card-body">
        <div class="row justify-content-center">
          <div class="col">
            <div class="row">
              <div>あ</div>
              <button type="submit" value="cn" name="lang" class="btn btn-block btn-primary">
                <i class="material-icons md-48">hearing</i>
              </button>
              <button type="submit" value="cn" name="lang" class="btn btn-block btn-primary">
                <i class="material-icons md-48">mic</i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-5 ">
    <div class="card card-default">
      <div class="card-header text-center">
        {{ trans('wai_record_voice.hirakana') }}
      </div>
      <div class="card-body">
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
</script>

@endsection
