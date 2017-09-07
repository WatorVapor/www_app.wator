@extends('wator.app')


@section('appnavbar')
  @include('home.navbar')
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
