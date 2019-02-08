@extends('wator.app')
@section('appnavbar')
  @include('secauth.navbar')
@endsection
@section('content')

<div class="row justify-content-md-center mt-md-5">
  <div class="col-md-8">
      <a href="/secauth/import" class="btn btn-danger btn-lg btn-block" role="button">{{trans('secauth_signup.import')}}</a>
   </div>
</div>
<br/>
<br/>
<div class="row justify-content-md-center">
  <div class="col-md-8 bg-primary">
    <h2 class="text-left ">1.{{trans('secauth_signup.agree_robot')}}</h2>
    <h2 class="text-left">2.{{trans('secauth_signup.agree_friend')}}</h2>
    <h2 class="text-left">3.{{trans('secauth_signup.privacy')}}</h2>
    <br/>
    <div class="mainbox center-block text-center">
      <button id="btn_yes" type="button" class="btn btn-success">{{trans('secauth_signup.agree_yes')}}</button>
      <button id="btn_no" type="button" class="btn btn-danger">{{trans('secauth_signup.agree_no')}}</button>
    </div>
    <br/>
    <div id="progressBox" class="mainbox center-block text-left">
      <div class="progress">
        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:100%">
          {{trans('secauth_signup.key_waiting')}}
        </div>
      </div>
    </div>
  </div>
</div>
<br/>
<br/>

<div class="row  justify-content-md-center" id="operate_key">
  <div class="col-md-8 bg-warning">
    <pre id="noticeBox" class="text-left text-danger ">
      {{trans('secauth_signup.key_important')}}
    </pre>
    <div class="mainbox center-block text-center">
      <a id="savefile" href="#" type="button" download="wator.secauth.key" class="btn btn-primary">{{trans('secauth_signup.key_save_file')}}</a>
      <button type="button" class="btn btn-success btn-clipboard" data-clipboard-target="#privateKey">{{trans('secauth_signup.key_copy')}}</button>
      <!--
      <button id="sendmail" type="button" class="btn btn-info">{{trans('secauth_signup.key_send_mail')}}</button>
      -->
    </div>
  </div>
</div>
<br/>
<br/>


<div class="row justify-content-md-center">
  <div class="col-lg-8">
    <form  id="secauth_upload_form" class="mt-2 mb-2" method="POST" action="#">
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

<div class="row justify-content-md-center">
  <div class="col-md-8 bg-info">
    <pre id="privateKey" class="text-left small" rows="40">
    </pre>
   </div>
</div>


<script src="/wator/secauth/js/auth.js" type="text/javascript"></script>
<script src="/wator/secauth/js/create.js" type="text/javascript"></script>

<script type="text/javascript">
  new ClipboardJS('.btn-clipboard');
</script>

<script>
  $(document).ready(function() {
    $("#btn_yes").click(function(){
      $("#progressBox").children().show();
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
     
      let priKey = SecAuth.getPriKey();
      $("#privateKey").text(priKey);
      $("#progressBox").children().hide();
      $("#operate_key").children().show();
      $("#savefile").show();
      $("#sendmail").show();
      $("#next_step").show();
      doUploadToken();
    });
    $("#btn_no").click(function(){
      window.location.href = '/';
    });
    $("#progressBox").children().hide();
    $("#operate_key").children().hide();
    $("#savefile").hide();
    $("#sendmail").hide();
    $("#next_step").hide();
    
    $("#savefile").click(function(){
      let priKey = SecAuth.getPriKey();
      let pubKey = SecAuth.getPubKey();
      let blob = new Blob([ priKey], { "type" : "text/plain" });
      //console.log(blob);
      document.getElementById("savefile").href = window.URL.createObjectURL(blob);
    });
    $("#sendmail").click(function(){
    });
  });
  function doUploadToken() {
    //document.forms['secauth_upload_form'].submit();
  }
  
</script>


@endsection
