@extends('wator.app')
@section('appnavbar')
  @include('secauth.navbar')
@endsection
@section('content')

<div class="row justify-content-md-center mt-5">
  <div class="col-6">
    <pre class="text-center text-danger bg-dark">
      {{trans('secauth_profile.key_export')}}
    </pre>
    <div class="mainbox center-block text-center">
      <a id="savefile" type="button" download="wator.secauth.key.json" class="btn btn-primary btn-block">{{trans('secauth_profile.key_save_file')}}</a>
    </div>
  </div>
</div>

<hr/>

<div class="row justify-content-md-center mt-1">
  <div class="col-8">
    <div class="card text-center text-white bg-dark bg-success">
      <div class="card-header">{{trans('secauth_profile.title')}}</div>
      <div class="card-body">
        <form  class="mt-2 mb-2" method="POST" action="#">
          {{ csrf_field() }}
          <div class="input-group mb-3">
            <div class="input-group-prepend align-middle">
              <span>{{trans('secauth_profile.apply_name')}}:</span>
            </div>
            <div class="input-group-prepend">
              <button type="submit" class="btn btn-outline-primary">
                <i class="material-icons " style="color:green;">done</i>
              </button>
            </div>
            <input type="text" name="user-name" class="form-control" value="{{ $user_name }}" aria-describedby="basic-addon1">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="/wator/secauth/js/auth.js" type="text/javascript"></script>

<script>
  $(document).ready(function() {
    $('#savefile').click(function(){
      let priKey = SecAuth.getPriKey();
      let blob = new Blob([ priKey], { 'type' : 'text/plain' });
      console.log(blob);
      document.getElementById('savefile').href = window.URL.createObjectURL(blob);
    });
  });
</script>

@endsection
