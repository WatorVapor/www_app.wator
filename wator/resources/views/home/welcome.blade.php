@extends('wator.app')

@section('appnavbar')
  @include('home.navbar')
@endsection

<style type="text/css">
.tales {
  width: 100%;
}
.carousel-inner{
  width:100%;
  max-height: 200px !important;
}
</style>

@section('content')
<div class="row justify-content-center" >
  <div class="col-10">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="/wator/images/brain.orig.png" alt="{{trans('welcome.ThirtyYearBrainResearch')}}">
          <div class="carousel-caption d-none d-md-block">
            <h3>{{trans('welcome.ThirtyYearBrainResearch')}}</h3>
          </div>
        </div>
        <div class="carousel-item">
          <img src="/wator/images/brain.header.jpg" alt="{{trans('welcome.ThirtyYearBrainResearch')}}">
          <div class="carousel-caption d-none d-md-block">
            <h3>{{trans('welcome.ThirtyYearStrongAI')}}</h3>
          </div>
        </div>
        <div class="carousel-item">
          <img src="/wator/images/digital.brain.reading.jpg" alt="{{trans('welcome.ThirtyYearBrainResearch')}}">
          <div class="carousel-caption d-none d-md-block">
            <h3>{{trans('welcome.FortyYearBrainRead')}}</h3>
          </div>
        </div>
      </div>
      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
  </div>
</div>
@endsection
