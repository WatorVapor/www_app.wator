@extends('rsaauth.app')

@section('appnavbar')
  @include('rsaauth.navbar')
@endsection


@section('content')

<div class="row justify-content-center" style="height:20px;">
</div>

<div class="row justify-content-center">
  <div class="col-8">
    <textarea id="import-key-value" class="w-100 text-left small" rows="10" data-toggle="tooltip" data-placement="top" title="paste -----BEGIN PRIVATE KEY----- -----BEGIN PUBLIC KEY-----">
    </textarea>
  </div>
</div>

<div class="row justify-content-center" id="import-key-verify">
  <div class="col-2">
    <button class="btn btn-info btn-block" onclick="onImportKey(this)">
      <spam>{{trans('rsaauth_login.check')}}</span><i class="material-icons " style="color:green;">check_circle</i>
    </button>
  </div>
</div>


<div class="row justify-content-center d-none" id="import-key-save">
  <div class="col-2">
    <button class="btn btn-success btn-block" onclick="onImportKey(this)">
      <spam>{{trans('rsaauth_login.apply')}}</span><i class="material-icons " style="color:orange;">done</i>
    </button>
  </div>
</div>

<div class="row justify-content-center d-none" id="import-key-discard">
  <div class="col-2">
    <button class="btn btn-daugh btn-block" onclick="ondiscardKey(this)">
      <spam>{{trans('rsaauth_login.discard')}}</span><i class="material-icons " style="color:red;">cancel</i>
    </button>
  </div>
</div>


<script>
  $(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>
@include('rsaauth.js.import')
@endsection
