@extends('rsaauth.app')

@section('appnavbar')
  @include('rsaauth.navbar')
@endsection


@section('content')

<div class="row justify-content-md-center">
  <div class="col-8">
    <div class="card mt-5 text-center text-white bg-dark bg-success">
      <div class="card-header">{{trans('rsaauth_profile.title')}}</div>
      <div class="card-body">
        <form  class="mt-2 mb-2" method="POST" action="/rsaauth/profile">
          {{ csrf_field() }}
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span>{{trans('rsaauth_profile.apply_name')}}:</span>
            </div>
            <div class="input-group-prepend">
              <button type="submit" class="btn btn-outline-primary">
                <i class="material-icons " style="color:green;">done</i>
              </button>
            </div>
            <input type="text" name="user-name" class="form-control" placeholder="{{ $user_name }}" aria-describedby="basic-addon1">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


@endsection
