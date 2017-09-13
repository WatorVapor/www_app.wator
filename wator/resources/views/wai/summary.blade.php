@extends('wator.app')
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-10 col-lg-offset-1">
      <div class="panel panel-default">
        <div class="panel-body">
          <pre style="white-space: pre-wrap ;">{{ $summary }}</pre>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
