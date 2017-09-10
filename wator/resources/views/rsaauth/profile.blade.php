@extends('rsaauth.app')

@section('appnavbar')
  @include('rsaauth.navbar')
@endsection


@section('content')

<div class="row justify-content-md-center">
  <div class="col-lg-8">
    <div class="card mt-5">
      <div class="card-header">{{trans('profile.title')}}</div>
      <div class="card-body">
        <form  class="mt-2 mb-2" method="POST" action="/rsaauth/profile">
          {{ csrf_field() }}
          <div class="input-group">
             <span class="input-group-btn">
               <button id="apply-name" type="button" class="btn btn-default">{{trans('profile.apply_name')}}</button>
             </span>
             <input type="text" name="user-name" class="form-control" placeholder="{{ $user_name }}" aria-describedby="basic-addon1">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


@endsection
