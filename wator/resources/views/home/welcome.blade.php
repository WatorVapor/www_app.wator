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
        <div class="carousel-item active">
          <img src="/wator/images/brain.orig.png" alt="{{trans('welcome.ThirtyYearBrainResearch')}}">
          <img src="/wator/images/brain.header.jpg" alt="{{trans('welcome.ThirtyYearBrainResearch')}}">
          <img src="/wator/images/digital.brain.reading.jpg" alt="{{trans('welcome.ThirtyYearBrainResearch')}}">
          <img src="/wator/images//brain.skelton.jpg" alt="{{trans('welcome.ThirtyYearBrainResearch')}}">
          <div class="carousel-caption d-none d-md-block">
            <h3 class="text-success">{{trans('welcome.ThirtyYearBrainResearch')}}</h3>
          </div>
        </div>
        <div class="carousel-item">
          <img src="/wator/images/ai.nl.jpg" alt="{{trans('welcome.ThirtyYearStrongAI')}}">
          <img src="/wator/images/ai.dnn.jpg" alt="{{trans('welcome.ThirtyYearStrongAI')}}">
          <img src="/wator/images/ai.dream.jpg" alt="{{trans('welcome.ThirtyYearStrongAI')}}">
          <img src="/wator/images/i.am.robot.png" alt="{{trans('welcome.ThirtyYearStrongAI')}}">
          <div class="carousel-caption d-none d-md-block">
            <h3 class="text-success">{{trans('welcome.ThirtyYearStrongAI')}}</h3>
          </div>
        </div>
        <div class="carousel-item">
          <img src="/wator/images/digital.Consciousness.reading.jpg" alt="{{trans('welcome.FortyYearBrainRead')}}">
          <img src="/wator/images/digital.brain.block.jpg" alt="{{trans('welcome.FortyYearBrainRead')}}">
          <img src="/wator/images/digital.soul.jpg" alt="{{trans('welcome.FortyYearBrainRead')}}">
          <img src="/wator/images/digital.Consciousness.binary.jpg" alt="{{trans('welcome.FortyYearBrainRead')}}">
          <img src="/wator/images/digital.brain.block.3d.jpg" alt="{{trans('welcome.FortyYearBrainRead')}}">
          <div class="carousel-caption d-none d-md-block">
            <h3 class="text-success">{{trans('welcome.FortyYearBrainRead')}}</h3>
          </div>
        </div>
        <div class="carousel-item">
          <img src="/wator/images/human.robot.jpg" alt="{{trans('welcome.FortyYearBrain2Robot')}}">
          <img src="/wator/images/robot.brain.why.jpg" alt="{{trans('welcome.FortyYearBrain2Robot')}}">
          <img src="/wator/images/robot.brain.white.jpg" alt="{{trans('welcome.FortyYearBrain2Robot')}}">
          <img src="/wator/images/robot.thinking.pose.jpg" alt="{{trans('welcome.FortyYearBrain2Robot')}}">
          <div class="carousel-caption d-none d-md-block">
            <h3 class="text-success">{{trans('welcome.FortyYearBrain2Robot')}}</h3>
          </div>
        </div>
        <div class="carousel-item">
          <img src="/wator/images/robot.rocket.block.jpg" alt="{{trans('welcome.FiftyYearRobot2Universe')}}">
          <img src="/wator/images/robot.star.space.jpg" alt="{{trans('welcome.FiftyYearRobot2Universe')}}">
          <img src="/wator/images/space.travel.jpg" alt="{{trans('welcome.FiftyYearRobot2Universe')}}">
          <img src="/wator/images/space.travel.land.jpg" alt="{{trans('welcome.FiftyYearRobot2Universe')}}">
          <div class="carousel-caption d-none d-md-block">
            <h3 class="text-success">{{trans('welcome.FiftyYearRobot2Universe')}}</h3>
          </div>
        </div>
        <div class="carousel-item">
          <img src="/wator/images/earth.kepler-20.jpg" alt="{{trans('welcome.HundredYearDason')}}">
          <img src="/wator/images/earth.kepler-20.glaxy.jpg" alt="{{trans('welcome.HundredYearDason')}}">
          <img src="/wator/images/kepler.daison.jpg" alt="{{trans('welcome.HundredYearDason')}}">
          <img src="/wator/images/kepler.daison.black.jpg" alt="{{trans('welcome.HundredYearDason')}}">
          <div class="carousel-caption d-none d-md-block">
            <h3 class="text-success">{{trans('welcome.HundredYearDason')}}</h3>
          </div>
        </div>
        <div class="carousel-item">
          <img src="/wator/images/human.robot.jpg" alt="{{trans('welcome.TwoHundredYearHuman')}}">
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
