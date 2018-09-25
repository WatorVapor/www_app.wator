@extends('wator.app')
@section('appnavbar')
  @include('home.navbar')
@endsection

@section('content')
<style type="text/css">
.tales {
  width: 100%;
}
.carousel-inner{
  width:100%;
  height:300px !important;
  max-height: 400px !important;
}
/*
.carousel-item.img {
  height:100%;
}
*/
</style>

<div class="row justify-content-center" >
  <div class="col-11 bg-secondary">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="5"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="6"></li>
      </ol>
      <div class="carousel-inner">
        <div class="carousel-item justify-content-center active">
          <img src="/wator/images/home/brain.orig.png" style="width:24%;" alt="">
          <img src="/wator/images/home/brain.header.jpg" style="width:24%;" alt="">
          <img src="/wator/images/home/digital.brain.reading.jpg" style="width:24%;" alt="">
          <img src="/wator/images/home/brain.skelton.jpg" style="width:24%;" alt="">
          <div class="carousel-caption">
            <h3 class="text-danger">{{trans('welcome.ThirtyYearBrainResearch')}}</h3>
          </div>
        </div>
        <div class="carousel-item justify-content-center">
          <img src="/wator/images/home/ai.nl.jpg" style="width:24%;" alt="">
          <img src="/wator/images/home/ai.dnn.jpg" style="width:24%;" alt="">
          <img src="/wator/images/home/ai.dream.jpg" style="width:24%;" alt="">
          <img src="/wator/images/home/i.am.robot.png" style="width:24%;" alt="">
          <div class="carousel-caption d-none d-md-block">
            <h3 class="text-danger">{{trans('welcome.ThirtyYearStrongAI')}}</h3>
          </div>
        </div>
        <div class="carousel-item justify-content-center">
          <img src="/wator/images/home/digital.Consciousness.reading.jpg" style="width:19%;" alt="">
          <img src="/wator/images/home/digital.brain.block.jpg" style="width:19%;" alt="">
          <img src="/wator/images/home/digital.soul.jpg" style="width:19%;" alt="">
          <img src="/wator/images/home/digital.Consciousness.binary.jpg" style="width:19%;" alt="">
          <img src="/wator/images/home/digital.brain.block.3d.jpg" style="width:19%;" alt="">
          <div class="carousel-caption d-none d-md-block">
            <h3 class="text-danger">{{trans('welcome.FortyYearBrainRead')}}</h3>
          </div>
        </div>
        <div class="carousel-item justify-content-center">
          <img src="/wator/images/home/human.robot.jpg" style="width:24%;" alt="">
          <img src="/wator/images/home/robot.brain.why.jpg" style="width:24%;" alt="">
          <img src="/wator/images/home/robot.brain.white.jpg" style="width:24%;" alt="">
          <img src="/wator/images/home/robot.thinking.pose.jpg" style="width:24%;" alt="">
          <div class="carousel-caption d-none d-md-block">
            <h3 class="text-danger">{{trans('welcome.FortyYearBrain2Robot')}}</h3>
          </div>
        </div>
        <div class="carousel-item justify-content-center">
          <!--
          <img src="/wator/images/home/robot.rocket.block.jpg" style="width:24%;transform: rotate(90deg);" alt="">
          -->
          <img src="/wator/images/home/robot.star.space.jpg" style="width:32%;" alt="">
          <img src="/wator/images/home/space.travel.jpg" style="width:32%;" alt="">
          <img src="/wator/images/home/space.travel.land.jpg" style="width:32%;" alt="">
          <div class="carousel-caption d-none d-md-block">
            <h3 class="text-danger">{{trans('welcome.FiftyYearRobot2Universe')}}</h3>
          </div>
        </div>
        <div class="carousel-item justify-content-center">
          <img src="/wator/images/home/earth.kepler-20.jpg" style="width:24%;" alt="">
          <img src="/wator/images/home/earth.kepler-20.glaxy.jpg" style="width:24%;" alt="">
          <img src="/wator/images/home/kepler.daison.jpg" style="width:24%;" alt="">
          <img src="/wator/images/home/kepler.daison.black.jpg" style="width:24%;" alt="">
          <div class="carousel-caption d-none d-md-block">
            <h3 class="text-danger">{{trans('welcome.HundredYearDason')}}</h3>
          </div>
        </div>
        <div class="carousel-item justify-content-center">
          <img src="/wator/images/home/human.robot.jpg" alt="">
          <div class="carousel-caption d-none d-md-block">
            <h3 class="text-danger">{{trans('welcome.TwoHundredYearHuman')}}</h3>
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
