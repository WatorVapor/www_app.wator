@extends('wator.app')


@section('appnavbar')
  @include('wai.navbar')
@endsection

@section('content')


<div class="row justify-content-center">
  <div class="col-lg-10 ">
    <div class="card card-default">
      <div class="card-body">
        <h4 class="card-title">{{ trans('wai_record_voice.hirakana') }}</h4>
      </div>
    </div>
  </div>
</div>


<script src="/wator/wai/notify.js" type="text/javascript"></script>

<script type="text/javascript">
  function onUpdateData(msg) {
    console.log('onUpdateData:msg=<',msg,'>');
  }
</script>

@endsection
