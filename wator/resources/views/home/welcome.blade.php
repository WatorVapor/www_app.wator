@extends('wator.app')

@section('appnavbar')
  @include('home.navbar')
@endsection


@section('content')
<div class="row" >
  <div class="col"></div>
  <div class="col-10 bg-danger text-nowrap">
      {{trans('about.content')}}
  </div>
  <div class="col"></div>
</div>
@endsection
