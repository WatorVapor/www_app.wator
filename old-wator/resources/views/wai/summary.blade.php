@extends('wator.app')
@section('appnavbar')
  @include('wai.navbar')
@endsection
@section('content')
<div class="row justify-content-center">
  <div class="col-lg-10">
    <div class="panel panel-default">
      <div class="panel-body">
        <pre style="white-space: pre-wrap ;">{{ $summary }}</pre>
      </div>
    </div>
  </div>
</div>
@endsection
