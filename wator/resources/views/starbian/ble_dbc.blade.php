@extends('wator.app')
@section('appnavbar')
  @include('starbian.navbar')
@endsection

@section('content')
<div class="row">
  <div class="col-2 mt-lg-5">
    <button type="button" class="btn btn-success btn-lg btn-block" onclick="onBLESearch(this)">Search</button>
  </div>
  <div class="col-2 mt-lg-5">
    <button type="button" class="btn btn-success btn-lg btn-block" onclick="onBLEConnect(this)">Connect</button>
  </div>
</div>


<div class="container mt-lg-5">
  <div class="row mt-lg-5 justify-content-center">
    <div class="col-6">
      <div class="input-group">
        <span class="input-group-btn">
          <button class="btn btn-primary" type="submit">1-255</button>
        </span>
        <input type="text" class="form-control" name="speed" placeholder="50"  value="50" onchange="onSpeedChange(this)"/>
    </div>
  </div>
</div>

<style>
  .btn-remote-controller {
    height: 180px !important;
    width: 180px !important;
  } 
</style>


<div class="container mt-lg-5">
  <div class="row mt-lg-5 justify-content-center">
    <div class="col-10">
      <div class="row align-items-start justify-content-center">
        <button type="submit" class="btn btn-lg btn-remote-controller btn-success" onclick="onDBCForward(this)"> <i class="material-icons md-48">keyboard_arrow_up</i></button>
      </div>
      <div class="row mt-lg-4 align-items-center justify-content-center">
        <button type="submit" class="btn btn-lg btn-remote-controller btn-success" onclick="onDBCLeft(this)" ><i class="material-icons md-48">keyboard_arrow_left</i></button>
        <button type="submit" class="btn btn-lg ml-lg-4 mr-lg-4 btn-remote-controller btn-danger" onclick="onDBCStop(this)"><i class="material-icons md-48">stop</i></button>
        <button type="submit" class="btn btn-lg btn-remote-controller btn-success " onclick="onDBCRight(this)"><i class="material-icons md-48">keyboard_arrow_right</i></button>
      </div>
      <div class="row mt-lg-4 align-items-end justify-content-center">
        <button type="submit" class="btn btn-lg btn-remote-controller btn-success" onclick="onDBCBack(this)"><i class="material-icons md-48">keyboard_arrow_down</i></button>
      </div>
    </div>
  </div>
</div>


<!--
<script src="/wator/starbian/js/ble.web.js" type="text/javascript"></script>
-->
@include('starbian.js.ble_web')

<script type="text/javascript">
  function onBLESearch(element) {
    runBLESource();
  }
</script>
@endsection
