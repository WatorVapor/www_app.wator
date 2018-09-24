@extends('wator.app')
@section('content')
<div class="container bg-warning">
  <div class="row">
    <button type="button" class="btn btn-success btn-lg btn-block">Start</button>
  </div>
  <div class="row">
    <button type="button" class="btn btn-danger btn-lg btn-block">Stop</button>
  </div>
</div>
<script type="text/javascript" src="js/app.audiorecord.js"></script>
@endsection
