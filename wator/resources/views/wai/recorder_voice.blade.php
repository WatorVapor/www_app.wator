@extends('wator.app')


@section('appnavbar')
  @include('wai.navbar')
@endsection

@section('content')


<script src="/wator/wai/notify.js" type="text/javascript"></script>

<script type="text/javascript">
  function onUpdateData(msg) {
    console.log('onUpdateData:msg=<',msg,'>');
  }
</script>

@endsection
