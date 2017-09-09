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
<style>
.wv-mainbox {
  width:61.8%;
  overflow-y: scroll;
}
</style>

<div class="wv-mainbox center-block well well-lg">
  <div class="input-group">
     <span class="input-group-btn">
       <button id="apply-name" type="button" class="btn btn-default">{{trans('profile.apply_name')}}</button>
     </span>
     <input type="text" id = "user-name" class="form-control" placeholder="{{ $user_name }}" aria-describedby="basic-addon1">
  </div>
</div>


@endsection
