@extends('wator.app')
@section('appnavbar')
  @include('wai.navbar')
@endsection
@section('content')
<div class="row">
  <div class="col-lg-10 col-lg-offset-1">
    <div class="panel panel-default">
      <div class="panel-body">
        <pre style="white-space: pre-wrap ;">{{ $summary }}</pre>
      </div>
    </div>
  </div>
</div>
@endsection
