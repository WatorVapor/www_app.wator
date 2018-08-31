@extends('wator.app')
@section('appnavbar')
  @include('starbian.navbar')
@endsection

@section('content')
@include('starbian.layout.key')
<hr/>
@include('starbian.layout.iot')

@include('starbian.js.starbian')
@include('starbian.js.keys')
@include('starbian.js.gofuro')
@endsection
