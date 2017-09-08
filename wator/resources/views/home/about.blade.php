@extends('wator.app')


@section('appnavbar')
  @include('home.navbar')
@endsection


@section('content')
<div class="row" >
  <div class="col"></div>
  <div class="col-10">
    <div class="col-text text-left">
      <pre class="bg-dark">{{trans('about.content')}}</pre>
    </div>
  </div>
  <div class="col"></div>
</div>
@endsection
