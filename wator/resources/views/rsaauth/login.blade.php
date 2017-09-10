@extends('rsaauth.app')

@section('appnavbar')
  @include('rsaauth.navbar')
@endsection


@section('content')

<div class="row justify-content-md-center">
  <div class="col-lg-8">
    <div class="card mt-5">
      <div class="card-header">{{trans('login.title')}}</div>
      <div class="card-body">
        <form  class="mt-2 mb-2" method="POST" action="/rsaauth/login">
          {{ csrf_field() }}
          <div class="input-group">
             <span class="input-group-btn">
               <button type="submit" class="btn btn-default">{{trans('profile.login')}}</button>
             </span>
             <input type="text" name="accessToken" class="form-control" placeholder="" aria-describedby="basic-addon1">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var RSAAuth = RSAAuth || {};

RSAAuth.getPubKey = function() {
  return localStorage.getItem('auth.rsa.key.public');
}
RSAAuth.getPriKey = function() {
  return localStorage.getItem('auth.rsa.key.private');
}
RSAAuth.getToken = function() {
  return localStorage.getItem('auth.rsa.token');
}

$(document).ready(function(){
  let privateKey = RSAAuth.getPriKey();
  let token = RSAAuth.getToken();
  console.log('token=<',token,'>');
});

</script>

@endsection
