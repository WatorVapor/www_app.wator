@extends('wator.app')
@section('appnavbar')
  @include('ppio.navbar')
@endsection

@section('content')
<style>
  .ble-chart-canvas {
    width:100%;
    height:200px;
  }
</style>
<div class="row">
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">8bit signed</div>
      <div class="panel-body">
        <canvas class="ble-chart-canvas ble-chart-canvas-signed"></canvas>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">8bit unsigned</div>
      <div class="panel-body">
        <canvas class="ble-chart-canvas ble-chart-canvas-unsigned"></canvas>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">16bit signed</div>
      <div class="panel-body">
        <canvas class="ble-chart-canvas ble-chart-canvas-signed"></canvas>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">16bit unsigned</div>
      <div class="panel-body">
        <canvas class="ble-chart-canvas ble-chart-canvas-unsigned"></canvas>
      </div>
    </div>
  </div>
</div>




<script type="text/javascript">
  function drawSignedCanvas(canvas) {
    var ctx = canvas.getContext("2d");
    console.log('canvas.height=<' + canvas.height + '>');
    console.log('canvas.width=<' + canvas.width + '>');
    ctx.lineWidth=2;
    ctx.beginPath();
    ctx.moveTo(0,canvas.height/2);
    ctx.lineTo(canvas.width,canvas.height/2);
    ctx.moveTo(1,0);
    ctx.lineTo(1,canvas.height);
    ctx.strokeStyle='black';
    ctx.stroke();
  }
  function drawUnsignedCanvas(canvas) {
    var ctx = canvas.getContext("2d");
    console.log('canvas.height=<' + canvas.height + '>');
    console.log('canvas.width=<' + canvas.width + '>');
    ctx.lineWidth=2;
    ctx.beginPath();
    ctx.moveTo(0,canvas.height-1);
    ctx.lineTo(canvas.width,canvas.height-1);
    ctx.moveTo(1,0);
    ctx.lineTo(1,canvas.height);
    ctx.strokeStyle='black';
    ctx.stroke();
  }

  let canvasAll = document.getElementsByClassName("ble-chart-canvas-signed");
  console.log(canvasAll);
  Array.prototype.forEach.call(canvasAll, function(canvas){
    console.log(canvas);
    drawSignedCanvas(canvas);
  });
  canvasAll = document.getElementsByClassName("ble-chart-canvas-unsigned");
  console.log(canvasAll);
  Array.prototype.forEach.call(canvasAll, function(canvas){
    console.log(canvas);
    drawUnsignedCanvas(canvas);
  });
</script>
@endsection
