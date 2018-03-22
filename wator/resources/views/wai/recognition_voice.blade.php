@extends('wator.app')
@section('appnavbar')
  @include('wai.navbar')
@endsection
@section('content')


<div class="row justify-content-center">
  <div class="col-10 ">
    <div class="row">
      <div class="col-2 ">
        <button type="submit" class="btn btn-lg btn-outline-dark rounded-circle" style="height:96px;width:96px;" onclick="onClickRecognition(this)">
          <i class="material-icons " style="font-size:60px;color:green;">cloud_upload</i>
          <span class="badge badge-light" id="wai-recoder-clip-in-local">0</span>
        </button>
       </div>
     </div>
  </div>
</div>


@include('wai.js.recognition_main')


@endsection
