@extends('wator.app')
@section('content')
<style>
pre {
  white-space: pre-wrap;
  word-break: break-all;
}
.text-story {
  font-size:18pt;
  font-family:'{{trans('app.font_family')}}';
  font-style: normal;
  font-weight: 400;
}
#btn-plus-zoom {
  margin-left:100px;
}
#btn-minus-zoom {
  margin-right:100px;
}

</style>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-4 col-md-offset-4">
    </div>
  </div>
</div>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-11 col-md-offset-1">
      <table class="table table-striped">
        <thead>
          <tr>
            <th class="table-col"><a href="/story/slip/top"> |<< </a></th>
            <th class="table-col"><a href="/story/slip/{{ $prev }}"> < </a></th>
            <th class="table-col"><h3 class="text-danger">{{ $chapter }}.{{ $title }}</h3></th>
            <th class="table-col"><a href="/story/slip/{{ $next }}"> > </a></th>
            <th class="table-col"><a href="/story/slip/last"> >>| </a></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-11 col-md-offset-1">
      <button type="button" class="btn btn-primary btn-lg" id="btn-plus-zoom">+</button>
      <button type="button" class="btn btn-warning btn-lg pull-right" id="btn-minus-zoom">-</button>
      <pre class="text-story text-left bg-info">{{ $content }}</pre>
    </div>
  </div>
</div>


<div class="container-fluid">
  <div class="row">
    <div class="col-md-11 col-md-offset-1">
      <table class="table table-striped">
        <thead>
          <tr>
            <th class="table-col"><a href="/story/slip/top"> |<< </a></th>
            <th class="table-col"><a href="/story/slip/{{ $prev }}"> < </a></th>
            <th class="table-col"></th>
            <th class="table-col"><a href="/story/slip/{{ $next }}"> > </a></th>
            <th class="table-col"><a href="/story/slip/last"> >>| </a></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

<script type="text/javascript">
function fontUnit(font_size) {
  if(font_size.endsWith('px')) {
    return 'px';
  }
  if(font_size.endsWith('in')) {
    return 'in';
  }
  if(font_size.endsWith('em')) {
    return 'em';
  }
  if(font_size.endsWith('%')) {
    return '%';
  }
  if(font_size.endsWith('pt')) {
    return 'pt';
  }
  return 'px';
}
$(document).ready(function(){
  $('#btn-plus-zoom').click(function(){
    let font_size = $('.text-story').css('font-size');
    console.log(font_size);
    let size = parseInt(font_size);
    console.log(size);
    let newSize = size + 1;
    let newFull = newSize + fontUnit(font_size);
    console.log(newFull);
    $('.text-story').css('font-size',newFull);
  });
  $('#btn-minus-zoom').click(function(){
    let font_size = $('.text-story').css('font-size');
    console.log(font_size);
    let size = parseInt(font_size);
    console.log(size);
    let newSize = size - 1;
    if(newSize < 9) {
      newSize = 9;
    }
    let newFull = newSize + fontUnit(font_size);
    console.log(newFull);
    $('.text-story').css('font-size',newFull);    
  });
});
</script>

@endsection
