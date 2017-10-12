@extends('wator.app')
@section('appnavbar')
  @include('ppio.navbar')
@endsection

@section('content')
<div class="row">
  <div class="col-2 mt-lg-5">
    <button type="button" class="btn btn-success btn-lg btn-block" onclick="onBLESearch(this)">Search</button>
  </div>
</div>


<div class="container mt-lg-5">
  <div class="row mt-lg-5 justify-content-center">
    <div class="col-6">
      <div class="input-group">
        <span class="input-group-btn">
          <button class="btn btn-primary" type="submit">1-255</button>
        </span>
        <input type="text" class="form-control" name="speed" placeholder="50"  value="50" />
    </div>
  </div>
</div>

<style>
  .btn-remote-controller {
    height: 80px !important;
    margin-buttom: 40px !important;
  } 
</style>


<div class="container mt-lg-5">
  <div class="row mt-lg-5 justify-content-center">
    <div class="col-6">
      <div class="row align-items-start justify-content-center">
        <button type="submit" class="btn btn-lg btn-remote-controller btn-success"><i class="material-icons md-48">keyboard_arrow_up</i></button>
      </div>
      <div class="row align-items-center justify-content-center">
        <button type="submit" class="btn btn-lg btn-success"><i class="material-icons md-48">keyboard_arrow_left</i></button>
        <button type="submit" class="btn btn-lg btn-danger"><i class="material-icons md-48">stop</i></button>
        <button type="submit" class="btn btn-lg btn-success"><i class="material-icons md-48">keyboard_arrow_right</i></button>
      </div>
      <div class="row align-items-end justify-content-center">
        <button type="submit" class="btn btn-lg btn-success"><i class="material-icons md-48">keyboard_arrow_down</i></button>
      </div>
    </div>
  </div>
</div>


<script src="/wator/ppio/js/ble.web.js" type="text/javascript"></script>

<script type="text/javascript">
  function onBLESearch(element) {
    runBLESource();
  }
</script>
@endsection
