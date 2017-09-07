@extends('wator.app')

@section('navbar')
<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light ">
  <div class="container">
    @include('wator.navbar')
    @include('home.navbar')
  </div>
  <script>
    $('[data-toggle="popover"]').popover();
  </script>
</nav>
@endsection

@section('content')
<div class="container">
  <div class="row" >
    <div class="col-md-10 col-md-offset-1">
    <div class="col-text text-left">
      <pre class="bg-danger">
       {{trans('about.content')}}
      </pre>
    </div>
    </div>
  </div>
</div>
@endsection
