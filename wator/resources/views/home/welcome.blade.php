@extends('wator.app')

@section('appnavbar')
  @include('home.navbar')
@endsection


@section('content')
<div class="container-fluid">
  <div class="row" >
    <div class="col"></div>
    <div class="col-10">
      <div class="col-text text-left">
        <pre class="bg-danger"> {{trans('about.content')}}</pre>
      </div>
    </div>
    <div class="col"></div>
  </div>
</div>
@endsection
