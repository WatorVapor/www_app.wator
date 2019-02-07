@extends('secauth.app')

@section('appnavbar')
  @include('secauth.navbar')
@endsection


@section('content')

<div id="sec.login.auto" hidden> {{ $auto}} </div>

<div class="row justify-content-md-center">
  <div class="col-lg-8">
    <div class="card mt-5 text-center text-white bg-dark bg-success">
      <div class="card-header">{{trans('secauth_login.title')}}</div>
      <div class="card-body">
        <form  id="secauth_login_form" class="mt-2 mb-2" method="POST" action="/secauth/login">
          <button type="submit" class="btn btn-success">
            <spam>{{trans('secauth_login.login')}}</span><i class="material-icons " style="color:green;">done</i>
          </button>
          {{ csrf_field() }}
          <div class="form-group text-left">
            <span class="input-group-text" for="sec.login.accessToken">{{trans('secauth_login.accessToken')}}</span>
            <textarea type="text" id="sec.login.accessToken" name="accessToken" class="form-control" cols="40" rows="3" readonly></textarea>
          </div>
          <div class="form-group text-left">
             <span class="input-group-text" for="sec.login.access">{{trans('secauth_login.access')}}</span>
             <textarea type="text" id="sec.login.access" name="access" class="form-control" cols="40" rows="3" readonly>{{ $SecLoginAccessKey }}</textarea>
          </div>
          <div class="form-group text-left">
            <span class="input-group-text"for="sec.login.signature">{{trans('secauth_login.signature')}}</span>
            <textarea type="text" id="sec.login.signature" name="signature" class="form-control" cols="40" rows="14" readonly>{{ $SecLoginAccessKey }}</textarea>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@include('secauth.js.login')
@endsection
