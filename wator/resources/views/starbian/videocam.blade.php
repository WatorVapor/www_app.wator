@extends('wator.app')
@section('appnavbar')
  @include('starbian.navbar')
@endsection

@section('content')
@include('starbian.js.starbian')
@include('starbian.layout.key')
<hr/>
@include('starbian.layout.camera')
@include('starbian.js.videocam')
@endsection
