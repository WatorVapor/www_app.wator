@extends('wator.app')
@section('appnavbar')
  @include('wai.navbar')
@endsection
@section('content')


<div class="row justify-content-center">
  <div class="col-10 justify-content-center">
    <div class="row justify-content-center">
      <div class="col-2 justify-content-center">
        <button type="submit" class="btn btn-lg btn-outline-dark rounded-circle" style="height:96px;width:96px;" onclick="onClickRecognition(this)">
          <i class="material-icons " style="font-size:60px;color:green;">keyboard_voice</i>
        </button>
       </div>
     </div>
  </div>
</div>

<div class="row justify-content-center">
  <div class="col-10 justify-content-center">
    <canvas id="reco-wave" class="w-100" height="200"></canvas>
  </div>
</div>


@include('wai.js.recognition_main')


@endsection
