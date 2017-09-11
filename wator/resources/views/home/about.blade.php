@extends('wator.app')


@section('appnavbar')
  @include('home.navbar')
@endsection


@section('content')
<div class="row bg-secondary justify-content-center" >
  <div class="col-10 text-left text-nowrap">
    <pre>{{trans('about.content')}}</pre>
  </div>
</div>
@endsection
