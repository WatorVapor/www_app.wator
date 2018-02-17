@extends('wator.app')


@section('appnavbar')
  @include('wai.navbar')
@endsection

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="row justify-content-center">
  <div class="col-lg-10 ">
    <div class="card card-default">
      <div class="card-body">
        <form class="form-horizontal" method="POST" action="#" accept-charset="utf-8">
          {{ csrf_field() }}
          <div class="form-group">
            <div class="col-lg-12">
              <textarea class="form-control inputfield text" cols="50" rows ="5" placeholder="{{ trans('wai_participle.inputsentence') }}" name="sentence">{{ $text }}</textarea>
            </div>
          </div>
          <div class="form-group">
            <div class="row justify-content-center">
              <div class="col-lg-2">
                <button type="submit" value="cn" name="lang" class="btn btn-block btn-primary"> {{ trans('wai_participle.chinese') }} </button>
              </div>
              <div class="col-lg-2">
                <button type="submit" value="ja" name="lang" class="btn btn-block btn-success"> {{ trans('wai_participle.japanese') }} </button>
              </div>
            </div>
         </div>
        </form>
      </div>
    </div>
  </div>
</div>

@if ($process)
<div class="row justify-content-center ui-update-toggle">
@else
<div class="row justify-content-center ui-update-toggle d-none">
@endif
  <div class="col-lg-10">
    <i class="fa fa-spinner fa-spin" style="font-size:96px;color:red"></i>
  </div>
</div>


<div class="row justify-content-center ui-update-toggle d-none">
  <div class="col-lg-10">
    <pre class="text-justify text-nowrap bg-warning">
      <h3 id="ui-update-all-words"></h3>
    </pre>
  </div>
</div>

<div class="row justify-content-center">
  <div class="col-lg-10" id="ui-update-graph">
    @foreach ($result as $sentence)
    <div class="card card-default text-center border border-danger">
      <div class="card-body">
        <h4 class="card-title">{{ $sentence['sentence'] }}</h4>
        <img class="card-img-bottom" src="{{ $sentence['graph'] }}.svg" alt="Card image cap">
      </div>
      <div class="card-footer">
        <a href="{{ $sentence['graph'] }}.svg" target="_blank" class="btn btn-primary">{{ trans('wai_participle.opengraph') }}</a>
        <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.wator.xyz/{{ $sentence['graph'] }}.png" target="_blank" class="btn btn-primary">{{ trans('wai_participle.facebook') }}</a>
      </div>
    </div>
    @endforeach
  </div>
</div>

<script src="/wator/wai/notify.js" type="text/javascript"></script>

<script type="text/javascript">

  let graph_card = `<div class="card card-default text-center border border-danger">
    <div class="card-body">
      <h4 class="card-title">##sentence##</h4>
      <img class="card-img-bottom" src="##graph##.svg" alt="Card image cap">
    </div>
    <div class="card-footer">
      <a href="##graph##.svg" target="_blank" class="btn btn-primary">##wai_participle.opengraph##</a>
      <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.wator.xyz/##graph##.png" target="_blank" class="btn btn-primary">##wai_participle.facebook##</a>
    </div>
  </div>`;
    

  function onUpdateData(msg) {
    console.log('onUpdateData:msg=<',msg,'>');
    $( ".ui-update-toggle" ).toggleClass('d-none');
    $( "#ui-update-all-words" ).text('');
    if(msg.wai && typeof msg.wai === 'object') {
      msg.wai.forEach(function(wai,index,ar){
        console.log('onUpdateData:wai=<',wai,'>');
        //console.log('onUpdateData:index=<',index,'>');
        //console.log('onUpdateData:ar=<',ar,'>');
        if(wai.sentence) {
          let oldText = $( "#ui-update-all-words" ).text();
          $( "#ui-update-all-words" ).text(oldText + wai.sentence);
        } else {
          if(wai.input) {
            let oldText = $( "#ui-update-all-words" ).text();
            $( "#ui-update-all-words" ).text(oldText + wai.input);
          }
        }
        if(wai.graph){
          let new_graph_card = '';
          if(wai.sentence) {
            new_graph_card = graph_card.replace('##sentence##',wai.sentence);
          }
          new_graph_card = new_graph_card.replace('##graph##',wai.graph);
          
          $( "#ui-update-graph" ).append(new_graph_card);
        }
      });
    }
  }
</script>

@endsection
