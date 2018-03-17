@extends('rsaauth.app')

@section('appnavbar')
  @include('rsaauth.navbar')
@endsection


@section('content')

<div class="row justify-content-center" style="height:20px;">
</div>

<div class="row justify-content-center">
  <div class="col-8">
    <textarea id="importKey" class="w-100 text-left small" rows="10" data-toggle="tooltip" data-placement="bottom" title="paste -----BEGIN PRIVATE KEY----- -----BEGIN PUBLIC KEY-----">
    </textarea>
  </div>
</div>

<div class="row justify-content-center">
  <div class="col-6">
    <button type="submit" class="btn btn-success btn-block">
      <spam>{{trans('rsaauth_login.apply')}}</span><i class="material-icons " style="color:green;">done</i>
    </button>
  </div>
</div>


<script>
  $(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>
@endsection
