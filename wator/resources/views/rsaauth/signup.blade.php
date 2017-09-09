@extends('rsaauth.app')

@section('appnavbar')
  @include('rsaauth.navbar')
@endsection


@section('content')

<div class="row">
  <div class="col-md-8 col-md-offset-2">
      <a href="{{ url('/rsaauth/import',[], TRUE) }}" class="btn btn-danger btn-lg btn-block" role="button">{{trans('signup.import')}}</a>
   </div>
</div>
<br/>
<br/>
<div class="row">
  <div class="col-md-8 col-md-offset-2 bg-primary">
    <h2 class="text-left ">1.{{trans('signup.agree_robot')}}</h2>
    <h2 class="text-left">2.{{trans('signup.agree_friend')}}</h2>
    <br/>
    <div class="mainbox center-block text-center">
      <button id="btn_yes" type="button" class="btn btn-success">{{trans('signup.agree_yes')}}</button>
      <button id="btn_no" type="button" class="btn btn-danger">{{trans('signup.agree_no')}}</button>
    </div>
    <br/>
    <div id="progressBox" class="mainbox center-block text-left">
      <div class="progress">
        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:100%">
          {{trans('signup.key_waiting')}}
        </div>
      </div>
    </div>
  </div>
</div>
<br/>
<br/>

<div class="row " id="operate_key">
  <div class="col-md-8 col-md-offset-2 bg-warning">
    <pre id="noticeBox" class="text-left text-danger ">
      {{trans('signup.key_important')}}
    </pre>
    <div class="mainbox center-block text-center">
      <a id="savefile" href="#" type="button" download="watorvapor.account.key" class="btn btn-primary">{{trans('signup.key_save_file')}}</a>
      <button type="button" class="btn btn-success btn-clipboard" data-clipboard-target="#privateKey">{{trans('signup.key_copy')}}</button>
      <!--
      <button id="sendmail" type="button" class="btn btn-info">{{trans('signup.key_send_mail')}}</button>
      -->
      <a href="{{ url('/rsaauth/profile',[], TRUE) }}" id="next_step" class="btn btn-info" role="button">{{trans('signup.key_next')}}</a>
    </div>
  </div>
</div>
<br/>
<br/>

<div class="row">
  <div class="col-md-8 col-md-offset-2 bg-info">
    <pre id="privateKey" class="text-left small" rows="40">
      -----BEGIN PRIVATE KEY-----

      -----BEGIN PUBLIC KEY-----
    </pre>
   </div>
</div>


<script src="/wator/rsaauth/js/create.js" type="text/javascript"></script>
<script src="/wator/js/rsaauth/js/upload.js" type="text/javascript"></script>
<script src="/wator/js/clipboard.min.js" type="text/javascript"></script>

<script type="text/javascript">
  new Clipboard('.btn-clipboard');
</script>

<script>
  $(document).ready(function() {
    $("#btn_yes").click(function(){
      $("#progressBox").children().show();
      RSAAuth.createKey(function(){
        RSAAuth.clearAccess();
        var priKey = RSAAuth.getPriKey();
        var pubKey = RSAAuth.getPubKey();
        $("#privateKey").text(priKey+'\n\r'+pubKey);
        $("#progressBox").children().hide();
        $("#operate_key").children().show();
        $("#savefile").show();
        $("#sendmail").show();
        $("#next_step").show();
        RSAAuth.upPubKey();
      });
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
      var priKey = RSAAuth.getPriKey();
      var pubKey = RSAAuth.getPubKey();
      var blob = new Blob([ priKey+'\n\r'+pubKey ], { "type" : "text/plain" });
      //console.log(blob);
      document.getElementById("savefile").href = window.URL.createObjectURL(blob);
    });
    $("#sendmail").click(function(){
    });
  });
</script>


@endsection
