@extends('wator.app')


@section('appnavbar')
  @include('home.navbar')
@endsection


@section('content')
<div class="row" >
  <div class="col"></div>
  <div class="col-10 bg-secondary text-left text-justify">
    {{trans('about.content')}}
  </div>
  <div class="col"></div>
</div>
@endsection
