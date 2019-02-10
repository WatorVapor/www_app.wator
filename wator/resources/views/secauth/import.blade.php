@extends('wator.app')
@section('appnavbar')
  @include('secauth.navbar')
@endsection
@section('content')

@php
$placement_tips = <<<EOT
{
  "kty": "EC",
  "crv": "P-256",
  "x": "...",
  "y": "...",
  "d": "..."
}
EOT;

@endphp


<div class="row justify-content-md-center">
  <div class="col-lg-8">
    <form  id="secauth_upload_form" class="mt-2 mb-2" method="POST" action="/secauth/signup#">
      {{ csrf_field() }}     
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text">{{trans('secauth_login.accessToken')}}</span>
        </div>
        <textarea type="text" id="sec.signup.accessToken" name="accessToken" class="form-control" rows="2" readonly></textarea>
        <div class="input-group-append">
          <button type="submit" class="btn btn-success d-none">
            <span>{{trans('secauth_import.apply')}}</span><i class="material-icons " style="color:green;">done</i>
          </button>
        </div>
      </div>
    </form>
  </div>
</div>


<div class="row justify-content-center">
  <div class="col-4">
    <textarea id="import-key-value" class="w-100 text-left small" rows="8" placeholder="{{ $placement_tips }}"></textarea>
  </div>
</div>

<div class="row justify-content-center" id="import-key-verify">
  <div class="col-2">
    <button class="btn btn-info btn-block" onclick="onImportKey(this)">
      <spam>{{trans('secauth_import.check')}}</span><i class="material-icons " style="color:orange;">check_circle</i>
    </button>
  </div>
</div>

<div class="row justify-content-center d-none" id="import-key-save">
  <div class="col-2">
    <button class="btn btn-success btn-block" onclick="onSaveKey(this)">
      <spam>{{trans('secauth_import.apply')}}</span><i class="material-icons " style="color:green;">done</i>
    </button>
  </div>
</div>

<div class="row justify-content-center d-none" id="import-key-discard">
  <div class="col-2">
    <button class="btn btn-danger btn-block" onclick="onDiscardKey(this)">
      <spam>{{trans('secauth_import.discard')}}</span><i class="material-icons " style="color:red;">cancel</i>
    </button>
  </div>
</div>





<div class="alert alert-success d-none" id="import-key-success" role="alert">
  Success!!
</div>

<div class="alert alert-danger d-none" id="import-key-failure" role="alert">
  Fatal Error!!,Do Again.
</div>

<script src="/wator/secauth/js/auth.js" type="text/javascript"></script>
<script src="/wator/secauth/js/import.js" type="text/javascript"></script>

<script>
  $(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>

@endsection
