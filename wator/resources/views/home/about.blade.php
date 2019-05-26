@extends('wator.app')
@section('appnavbar')
  @include('home.navbar')
@endsection
@section('content')
<div class="row justify-content-center mt-5 mb-1" >
  <div class="col-8 text-left text-nowrap text-primary bg-light">
    <pre class="font-weight-bold" >{{trans('about.content')}}</pre>
  </div>
</div>
@endsection
