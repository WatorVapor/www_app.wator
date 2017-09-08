@extends('wator.app')


@section('appnavbar')
  @include('home.navbar')
@endsection


@section('content')
<div class="row" >
  <div class="col"></div>
  <div class="col-10 bg-secondary text-left text-justify">
    <p>{{trans('about.content')}}</p>
  </div>
  <div class="col"></div>
</div>
@endsection
