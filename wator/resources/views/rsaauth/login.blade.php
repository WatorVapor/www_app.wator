@extends('rsaauth.app')

@section('appnavbar')
  @include('rsaauth.navbar')
@endsection


@section('content')

<div id="rsa.login.auto" hidden> {{ $auto}} </div>

<div class="row justify-content-md-center">
  <div class="col-lg-8">
    <div class="card mt-5 text-center text-white bg-dark bg-success">
      <div class="card-header">{{trans('rsaauth_login.title')}}</div>
      <div class="card-body">
        <form  id="rsaauth_login_form" class="mt-2 mb-2" method="POST" action="/rsaauth/login">
          {{ csrf_field() }}
          <button type="submit" class="btn btn-success">
            <spam>{{trans('rsaauth_login.login')}}</span><i class="material-icons " style="color:green;">done</i>
          </button>
          <div class="form-group text-left">
            <span class="input-group-text" for="rsa.login.accessToken">{{trans('rsaauth_login.accessToken')}}</label>
            <textarea id="rsa.login.accessToken" name="accessToken" class="form-control" disabled cols="40" rows="3" aria-describedby="basic-addon1"></textarea>
          </div>
          <div class="form-group text-left">
             <span class="input-group-text" for="rsa.login.access">{{trans('rsaauth_login.access')}}</span>
             <textarea id="rsa.login.access" name="access" class="form-control" disabled cols="40" rows="3" aria-describedby="basic-addon1" value="{{ $RsaLoginAccessKey }}"></textarea>
          </div>
          <div class="form-group text-left">
            <span class="input-group-text"for="rsa.login.signature">{{trans('rsaauth_login.signature')}}</span>
            <textarea id="rsa.login.signature" name="signature" class="form-control" disabled cols="40" rows="14" aria-describedby="basic-addon1" value="{{ $RsaLoginAccessKey }}"></textarea>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@include('rsaauth.js.login')

@endsection
