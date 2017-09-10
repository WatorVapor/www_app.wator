@extends('rsaauth.app')

@section('appnavbar')
  @include('rsaauth.navbar')
@endsection


@section('content')

<script src="/wator/rsaauth/js/profile.js" type="text/javascript"></script>
<script>
  $(document).ready(function() {
    $('#apply-name').click(function(){
      var name= $('#user-name').val();
      console.log(name);
      RSAAuth.profile({'user':name});
    });
  });
</script>

<div class="row justify-content-md-center">
  <div class="card mt-5">
    <div class="card-header">
      {{trans('profile.title')}}
    </div>
    <div class="card-body">
      <form  class="mt-2 mb-2">
        <div class="input-group">
           <span class="input-group-btn">
             <button id="apply-name" type="button" class="btn btn-default">{{trans('profile.apply_name')}}</button>
           </span>
           <input type="text" id = "user-name" class="form-control" placeholder="{{ $user_name }}" aria-describedby="basic-addon1">
        </div>
      </form>
    </div>
  </div>
<!--
  <div class="col-md-6 bg-primary mt-5">
    <form  class="mt-2 mb-2">
      <div class="input-group">
         <span class="input-group-btn">
           <button id="apply-name" type="button" class="btn btn-default">{{trans('profile.apply_name')}}</button>
         </span>
         <input type="text" id = "user-name" class="form-control" placeholder="{{ $user_name }}" aria-describedby="basic-addon1">
      </div>
    </form>
  </div>
-->
</div>


@endsection
