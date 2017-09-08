@extends('wator.app')


@section('appnavbar')
  @include('home.navbar')
@endsection


@section('content')
<div class="row" >
  <div class="col"></div>
  <div class="col-10 text-left bg-secondary">
    {{trans('about.content')}}
  </div>
  <div class="col"></div>
</div>
@endsection
