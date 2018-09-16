@extends('wator.app')
@section('appnavbar')
  @include('starbian.navbar')
@endsection

@section('content')
<script src="/wator/starbian/js/starbian.js" type="text/javascript"></script>
@include('starbian.layout.key')
<hr/>
@include('starbian.layout.camera',['mobile'=>True])
@include('starbian.js.m_localstorage')
@endsection
