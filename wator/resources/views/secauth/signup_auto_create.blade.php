@extends('wator.app')
@section('appnavbar')
  @include('secauth.navbar')
@endsection
@section('content')


<div class="row justify-content-md-center">
  <div class="col-lg-8">
    <form  id="secauth_upload_form" class="mt-2 mb-2" method="POST" action="/secauth/signup">
      {{ csrf_field() }}     
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text">{{trans('secauth_login.accessToken')}}</span>
        </div>
        <textarea type="text" id="sec.signup.accessToken" name="accessToken" class="form-control" rows="2" readonly></textarea>
        <div class="input-group-append">
          <button type="submit" class="btn btn-success">
            <span>{{ trans('secauth_signup.key_next') }}</span><i class="material-icons " style="color:green;">done</i>
          </button>
        </div>
      </div>
    </form>
  </div>
</div>


<script src="/wator/secauth/js/auth.js" type="text/javascript"></script>
<script src="/wator/secauth/js/create.js" type="text/javascript"></script>

<script type="text/javascript">
  new ClipboardJS('.btn-clipboard');
</script>

<script>
  $(document).ready(function() {
    const token = SecAuth.createKey();
    console.log('token=<',token,'>');
    SecAuth.clearAccess();
    $("#sec.signup.accessToken").val(token);
    let elemToken = document.getElementById("sec.signup.accessToken");
    console.log('elemToken=<',elemToken,'>');
    if(elemToken) {
      elemToken.value = token;
      console.log('elemToken.value=<',elemToken.value,'>');
    }
    doUploadToken();
  });
  function doUploadToken() {
    document.forms['secauth_upload_form'].submit();
  }
  
</script>


@endsection
