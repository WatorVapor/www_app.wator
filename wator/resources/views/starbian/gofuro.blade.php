@extends('wator.app')
@section('appnavbar')
  @include('starbian.navbar')
@endsection

@section('content')
<script src="/wator/starbian/js/starbian.js" type="text/javascript"></script>
@include('starbian.layout.key')
<hr/>
@include('starbian.layout.iot')
@include('starbian.js.gofuro')
@endsection
