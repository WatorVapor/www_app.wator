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
  <div class="card" style="width: 20rem;">
    <img class="card-img-top" src="..." alt="Card image cap">
    <div class="card-body">
      <h4 class="card-title">Card title</h4>
      <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
      <a href="#" class="btn btn-primary">Go somewhere</a>
    </div>
  </div>

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
</div>


@endsection
