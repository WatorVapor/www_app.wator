@extends('wator.app')
@section('appnavbar')
  @include('wai.navbar')
@endsection
@section('content')
<div class="row justify-content-center">
  <div class="col-10 text-center mt-5">
    <h1>大家一起来帮助人工智能学习语言</h1>
  </div>
</div>

<div class="row justify-content-center">
  @include('wai.puzzle.wordteach.yesno')
</div>

<!--
<div class="row justify-content-center">
  <div class="col-6">
    <button class="btn btn-danger btn-block" type="button" onclick="onUIClickNextWords(this)">
      <h1>新一批<h1>
    </button>
  </div>
</div>
-->

<script>
  const onUIClickNextWords = (elem) => {
    console.log('onUIClickNextWords elem=<',elem,'>');
    teachNextWords();
  }
  
</script>


@endsection

