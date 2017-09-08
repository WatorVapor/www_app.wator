@extends('wator.app')


@section('appnavbar')
  @include('home.navbar')
@endsection


@section('content')
<div class="row bg-secondary" >
  <div class="col"></div>
  <div class="col-10 text-left text-nowrap">
    <pre>{{trans('about.content')}}</pre>
  </div>
  <div class="col"></div>
</div>
@endsection
