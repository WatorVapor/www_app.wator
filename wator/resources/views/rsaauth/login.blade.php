@extends('rsaauth.app')

@section('appnavbar')
  @include('rsaauth.navbar')
@endsection


@section('content')

<div id="rsa.login.auto" hidden> {{ $auto}} </div>

<div class="row justify-content-md-center">
  <div class="col-lg-8">
    <div class="card mt-5">
      <div class="card-header">{{trans('rsaauth_login.title')}}</div>
      <div class="card-body">
        <form  id="rsaauth_login_form" class="mt-2 mb-2" method="POST" action="/rsaauth/login">
          {{ csrf_field() }}
          <div class="form-group">
             <label for="rsa.login.accessToken">{{trans('rsaauth_login.accessToken')}}</label>
             <input type="text" id="rsa.login.accessToken" name="accessToken" class="form-control" placeholder="" aria-describedby="basic-addon1">
          </div>
          <div class="form-group">
             <label for="rsa.login.access">{{trans('rsaauth_login.access')}}</label>
             <input type="text" id="rsa.login.access" name="access" class="form-control" placeholder="" aria-describedby="basic-addon1" value="{{ $RsaLoginAccessKey }}">
          </div>
          <div class="form-group">
             <label for="rsa.login.signature">{{trans('rsaauth_login.signature')}}</label>
             <input type="text" id="rsa.login.signature" name="signature" class="form-control" placeholder="" aria-describedby="basic-addon1" value="{{ $RsaLoginAccessKey }}">
          </div>
          <button type="submit" class="btn btn-default">{{trans('rsaauth_login.login')}}</button>
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
  let elemToken = document.getElementById("rsa.login.accessToken");
  console.log('elemToken=<',elemToken,'>');
  if(elemToken) {
    elemToken.value = token;
    console.log('elemToken.value=<',elemToken.value,'>');
  }
  
  let rsaKey = KEYUTIL.getKeyFromPlainPrivatePKCS8PEM(privateKey);
  console.log('rsaKey=<',rsaKey,'>');
  let elemAccess = document.getElementById("rsa.login.access");
  if(elemAccess) {
    let access = elemAccess.value;
    let signature = rsaKey.sign(access,"sha256");
    console.log('access=<',access,'>');
    console.log('signature=<',signature,'>');
    let elemSign = document.getElementById("rsa.login.signature");
    if(elemSign) {
      elemSign.value = signature;
      let elemAuto = document.getElementById("rsa.login.auto");
      if(elemAuto) {
        if(elemAuto.value === 'true') {
          doAutoLogin();
        }
      }
    }
  }

});
function doAutoLogin() {
  document.forms['rsaauth_login_form'].submit();
}

</script>

@endsection
