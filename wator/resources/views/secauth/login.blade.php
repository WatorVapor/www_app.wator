@extends('wator.app')
@section('appnavbar')
  @include('secauth.navbar')
@endsection
@section('content')

<div id="sec.login.auto" hidden> {{ $auto}} </div>

<div class="row justify-content-md-center">
  <div class="col-lg-8">
    <div class="card mt-5 text-center text-white bg-dark bg-success">
      <div class="card-header"><h1>{{trans('secauth_login.title')}}</h1></div>
      <div class="card-body">
        <form  id="secauth_login_form" class="mt-2 mb-2" method="POST" action="/secauth/login">
          <button type="submit" class="btn btn-success btn-block mb-5">
            <h3>{{trans('secauth_login.login')}}</h3>
          </button>
          {{ csrf_field() }}
          <div class="form-group text-left">
            <span class="input-group-text" for="sec.login.accountToken">{{trans('secauth_login.accountToken')}}</span>
            <textarea type="text" id="sec.login.accountToken" name="accountToken" class="form-control" cols="40" rows="2" readonly></textarea>
          </div>
         <div class="form-group text-left">
            <span class="input-group-text" for="sec.login.accountKeyId">{{trans('secauth_login.accountKeyId')}}</span>
            <textarea type="text" id="sec.login.accountKeyId" name="accountKeyId" class="form-control" cols="40" rows="2" readonly></textarea>
          </div>
          <div class="form-group text-left">
             <span class="input-group-text" for="sec.login.access">{{trans('secauth_login.access')}}</span>
             <textarea type="text" id="sec.login.access" name="access" class="form-control" cols="40" rows="1" readonly>{{ $SecLoginAccessKey }}</textarea>
          </div>
          <div class="form-group text-left">
            <span class="input-group-text"for="sec.login.signature">{{trans('secauth_login.signature')}}</span>
            <textarea type="text" id="sec.login.signature" name="signature" class="form-control" cols="40" rows="2" readonly></textarea>
          </div>
          <div class="form-group text-left">
            <span class="input-group-text"for="sec.login.lang">{{trans('secauth_login.lang')}}</span>
            <textarea type="text" id="sec.login.lang" name="lang" class="form-control" cols="40" rows="1" readonly></textarea>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="/wator/secauth/js/auth.js" type="text/javascript"></script>
<script src="/wator/secauth/js/login.js" type="text/javascript"></script>
@endsection
