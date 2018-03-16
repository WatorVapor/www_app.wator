@extends('rsaauth.app')

@section('appnavbar')
  @include('rsaauth.navbar')
@endsection


@section('content')

<div class="row justify-content-md-center">
  <div class="col-lg-8">
    <div class="card mt-5 text-center">
      <div class="card-header">{{trans('rsaauth_profile.title')}}</div>
      <div class="card-body">
        <form  class="mt-2 mb-2" method="POST" action="/rsaauth/profile">
          {{ csrf_field() }}
          <div class="input-group-prepend">
            <span>{{trans('rsaauth_profile.apply_name')}}:</span>
           </div>
          <div class="input-group-prepend">
            <button class="btn btn-outline-secondary" type="button">
              <i class="material-icons " style="font-size:36px;color:green;">done</i>
            </button>
           </div>
          <div class="input-group">
             <span class="input-group-btn">
              <span>{{trans('rsaauth_profile.apply_name')}}:</span>
              <button type="submit" class="btn btn-success">
                <i class="material-icons " style="font-size:36px;color:green;">done</i>
              </button>
             </span>
             <input type="text" name="user-name" class="form-control" placeholder="{{ $user_name }}" aria-describedby="basic-addon1">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


@endsection
