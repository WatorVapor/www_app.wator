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
  height:400px !important;
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
          <img src="/wator/images/brain.orig.png" style="width:25%;height:100%;" alt="">
          <img src="/wator/images/brain.header.jpg" style="width:25%;height:100%;" alt="">
          <img src="/wator/images/digital.brain.reading.jpg" style="width:25%;height:100%;" alt="">
          <img src="/wator/images//brain.skelton.jpg" style="width:25%;height:100%;" alt="">
          <div class="carousel-caption">
            <h3 class="text-success">{{trans('welcome.ThirtyYearBrainResearch')}}</h3>
            <p class="text-success">{{trans('welcome.ThirtyYearBrainResearch')}}</p>
          </div>
        </div>
        <div class="carousel-item justify-content-center">
          <img src="/wator/images/ai.nl.jpg" alt="">
          <img src="/wator/images/ai.dnn.jpg" alt="">
          <img src="/wator/images/ai.dream.jpg" alt="">
          <img src="/wator/images/i.am.robot.png" alt="">
          <div class="carousel-caption d-none d-md-block">
            <h3 class="text-success">{{trans('welcome.ThirtyYearStrongAI')}}</h3>
          </div>
        </div>
        <div class="carousel-item justify-content-center">
          <img src="/wator/images/digital.Consciousness.reading.jpg" alt="">
          <img src="/wator/images/digital.brain.block.jpg" alt="">
          <img src="/wator/images/digital.soul.jpg" alt="">
          <img src="/wator/images/digital.Consciousness.binary.jpg" alt="">
          <img src="/wator/images/digital.brain.block.3d.jpg" alt="">
          <div class="carousel-caption d-none d-md-block">
            <h3 class="text-success">{{trans('welcome.FortyYearBrainRead')}}</h3>
          </div>
        </div>
        <div class="carousel-item justify-content-center">
          <img src="/wator/images/human.robot.jpg" alt="">
          <img src="/wator/images/robot.brain.why.jpg" alt="">
          <img src="/wator/images/robot.brain.white.jpg" alt="">
          <img src="/wator/images/robot.thinking.pose.jpg" alt="">
          <div class="carousel-caption d-none d-md-block">
            <h3 class="text-success">{{trans('welcome.FortyYearBrain2Robot')}}</h3>
          </div>
        </div>
        <div class="carousel-item justify-content-center">
          <img src="/wator/images/robot.rocket.block.jpg" alt="">
          <img src="/wator/images/robot.star.space.jpg" alt="">
          <img src="/wator/images/space.travel.jpg" alt="">
          <img src="/wator/images/space.travel.land.jpg" alt="">
          <div class="carousel-caption d-none d-md-block">
            <h3 class="text-success">{{trans('welcome.FiftyYearRobot2Universe')}}</h3>
          </div>
        </div>
        <div class="carousel-item justify-content-center">
          <img src="/wator/images/earth.kepler-20.jpg" alt="">
          <img src="/wator/images/earth.kepler-20.glaxy.jpg" alt="">
          <img src="/wator/images/kepler.daison.jpg" alt="">
          <img src="/wator/images/kepler.daison.black.jpg" alt="">
          <div class="carousel-caption d-none d-md-block">
            <h3 class="text-success">{{trans('welcome.HundredYearDason')}}</h3>
          </div>
        </div>
        <div class="carousel-item justify-content-center">
          <img src="/wator/images/human.robot.jpg" alt="">
          <div class="carousel-caption d-none d-md-block">
            <h3 class="text-success">{{trans('welcome.TwoHundredYearHuman')}}</h3>
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
