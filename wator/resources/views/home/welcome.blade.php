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
  height:300px !important;
  max-height: 600px !important;
}
/*
.carousel-item.img {
  height:100%;
}
*/
</style>

@section('content')
<div class="row justify-content-center" >
  <div class="col-10 bg-secondary">
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
          <img src="/wator/images/brain.orig.png" style="width:24%;" alt="">
          <img src="/wator/images/brain.header.jpg" style="width:24%;" alt="">
          <img src="/wator/images/digital.brain.reading.jpg" style="width:24%;" alt="">
          <img src="/wator/images//brain.skelton.jpg" style="width:24%;" alt="">
          <div class="carousel-caption">
            <h3 class="text-primary">{{trans('welcome.ThirtyYearBrainResearch')}}</h3>
          </div>
        </div>
        <div class="carousel-item justify-content-center">
          <img src="/wator/images/ai.nl.jpg" style="width:24%;" alt="">
          <img src="/wator/images/ai.dnn.jpg" style="width:24%;" alt="">
          <img src="/wator/images/ai.dream.jpg" style="width:24%;" alt="">
          <img src="/wator/images/i.am.robot.png" style="width:24%;" alt="">
          <div class="carousel-caption d-none d-md-block">
            <h3 class="text-primary bg-light">{{trans('welcome.ThirtyYearStrongAI')}}</h3>
          </div>
        </div>
        <div class="carousel-item justify-content-center">
          <img src="/wator/images/digital.Consciousness.reading.jpg" style="width:19%;" alt="">
          <img src="/wator/images/digital.brain.block.jpg" style="width:19%;" alt="">
          <img src="/wator/images/digital.soul.jpg" style="width:19%;" alt="">
          <img src="/wator/images/digital.Consciousness.binary.jpg" style="width:19%;" alt="">
          <img src="/wator/images/digital.brain.block.3d.jpg" style="width:19%;" alt="">
          <div class="carousel-caption d-none d-md-block">
            <h3 class="text-primary">{{trans('welcome.FortyYearBrainRead')}}</h3>
          </div>
        </div>
        <div class="carousel-item justify-content-center">
          <img src="/wator/images/human.robot.jpg" style="width:24%;" alt="">
          <img src="/wator/images/robot.brain.why.jpg" style="width:24%;" alt="">
          <img src="/wator/images/robot.brain.white.jpg" style="width:24%;" alt="">
          <img src="/wator/images/robot.thinking.pose.jpg" style="width:24%;" alt="">
          <div class="carousel-caption d-none d-md-block">
            <h3 class="text-primary">{{trans('welcome.FortyYearBrain2Robot')}}</h3>
          </div>
        </div>
        <div class="carousel-item justify-content-center">
          <!--
          <img src="/wator/images/robot.rocket.block.jpg" style="width:24%;transform: rotate(90deg);" alt="">
          -->
          <img src="/wator/images/robot.star.space.jpg" style="width:32%;" alt="">
          <img src="/wator/images/space.travel.jpg" style="width:32%;" alt="">
          <img src="/wator/images/space.travel.land.jpg" style="width:32%;" alt="">
          <div class="carousel-caption d-none d-md-block">
            <h3 class="text-primary">{{trans('welcome.FiftyYearRobot2Universe')}}</h3>
          </div>
        </div>
        <div class="carousel-item justify-content-center">
          <img src="/wator/images/earth.kepler-20.jpg" style="width:24%;" alt="">
          <img src="/wator/images/earth.kepler-20.glaxy.jpg" style="width:24%;" alt="">
          <img src="/wator/images/kepler.daison.jpg" style="width:24%;" alt="">
          <img src="/wator/images/kepler.daison.black.jpg" style="width:24%;" alt="">
          <div class="carousel-caption d-none d-md-block">
            <h3 class="text-primary">{{trans('welcome.HundredYearDason')}}</h3>
          </div>
        </div>
        <div class="carousel-item justify-content-center">
          <img src="/wator/images/human.robot.jpg" alt="">
          <div class="carousel-caption d-none d-md-block">
            <h3 class="text-primary">{{trans('welcome.TwoHundredYearHuman')}}</h3>
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
