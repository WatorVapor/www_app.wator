@extends('wator.app')
@section('appnavbar')
  @include('secauth.navbar')
@endsection
@section('content')

<div class="row justify-content-md-center">
  <div class="col-8">
    <div class="card mt-5 text-center text-white bg-dark bg-success">
      <div class="card-header">{{trans('secauth_profile.title')}}</div>
      <div class="card-body">
        <form  class="mt-2 mb-2" method="POST" action="/secauth/profile">
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


@endsection
