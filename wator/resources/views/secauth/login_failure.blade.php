@extends('wator.app')
@section('appnavbar')
  @include('secauth.navbar')
@endsection
@section('content')
<div class="row justify-content-md-center">
  <h1>登录失败<h1>
</div>
<hr/>
<div class="row justify-content-md-center">
  <h3>{{ $details }}</h3>
</div>

@endsection
