@extends('wator.app')
@section('appnavbar')
  @include('wai.navbar')
@endsection
@section('content')
<div class="row justify-content-center">
  <div class="col-10 text-center">
    <h1>大家一起来帮助人工智能学习中文</h1>
  </div>
</div>

<div class="row justify-content-center">
  @include('wai.puzzle.wordteach.yesno')
</div>

<div class="row justify-content-center">
  <div class="col-5">
    正在制作当中。。。
  </div>
</div>

@endsection
