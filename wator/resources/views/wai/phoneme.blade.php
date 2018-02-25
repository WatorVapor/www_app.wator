<div class="card card-default text-center">
  <div class="card-body">
    <h1 class="card-title" style="font-size:96px;">{{ $phoneme }}</h1>
    <h6 class="card-title" style="font-size:18px;">{{ $finnish }}/{{ $total }}</h6>
    <pre class="card-title" style="font-size:48px;color:red;">{{ $phoneme_help }}</pre>
    
    <div class="row">
      <div class="col  m-0 p-0">
        <button type="submit" class="btn btn-lg btn-outline-dark rounded-circle" style="height:96px;width:96px;">
          <i class="material-icons " style="font-size:60px;color:green;">hearing</i>
        </button>
      </div>
      <div class="col  m-0 p-0 d-none" id="wai-recoder-clip-done">
        <button type="submit" class="btn btn-lg btn-outline-dark rounded-circle" style="height:96px;width:96px;" onclick="onClickDoneBtn(this)>
          <i class="material-icons " style="font-size:60px;color:green;">done</i>
        </button>
      </div>
      <div class="col  m-0 p-0 d-none" id="wai-recoder-clip-upload">
        <form method="POST" action="#" accept-charset="utf-8">
          {{ csrf_field() }}
          <div class="form-group d-none">
            <input type="text" class="" name="phoneme" value="{{ $phoneme }}"></input>
            <input type="text" class="" name="lang" value="{{ $lang }}"></input>
            <input type="text" class="" name="ipfs" value="ipfs"></input>
          </div>
          <button type="submit" class="btn btn-lg btn-outline-dark rounded-circle" style="height:96px;width:96px;">
            <i class="material-icons " style="font-size:60px;color:green;">cloud_upload</i>
          </button>
        </form>
      </div>
      <div class="col  m-0 p-0">
        <button type="submit" class="btn btn-lg btn-outline-dark rounded-circle" style="height:96px;width:96px;" onclick="onClickRecordBtn(this)">
          <i class="material-icons " style="font-size:60px;color:red;">mic</i>
        </button>
        <div class="progress">
          <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
        </div>
      </div>
    </div>

    <div class="row d-none">
      <div class="col  m-0 p-0">
        <audio controls id="wai-recoder-audio-standard">
          <source src="" type="audio/webm">
        </audio>
      </div>
      <div class="col  m-0 p-0">
        <audio controls id="wai-recoder-audio-train">
          <source src="" type="audio/webm">
        </audio>
      </div>
    </div>

    <hr/>

<!--
    <div class="row d-none" id="wai-recoder-clip-operator">
      <div class="col  m-0 p-0">
        <button type="submit" class="btn btn-lg btn-outline-dark rounded-circle" style="height:96px;width:96px;">
          <i class="material-icons " style="font-size:60px;color:green;">cloud_upload</i>
        </button>
      </div>
    </div>
-->    
    <hr/>

<!--    
    <div class="row">
      <div class="col  m-0 p-0">
      </div>
      <div class="col  m-0 p-0">
        <input id="ex1" data-slider-id='ex1Slider' type="text" data-slider-min="0" data-slider-max="20" data-slider-step="1" data-slider-value="14"/>
      </div>
    </div>
    <br/>
-->    
    
    <div class="row">
      <div class="col  m-0 p-0">
        <canvas id="wai-recoder-canvas-standard"></canvas>
      </div>
    </div>

    <div class="row">
      <div class="col  m-0 p-0">
        <canvas id="wai-recoder-canvas-train"></canvas>
      </div>
    </div>

  </div>
</div>

<!--
<style>
#ex1Slider .slider-selection {
    background: #BABABA;
}
</style>

<script type="text/javascript">
$('#ex1').slider({
  formatter: function(value) {
    console.log('formatter value=<',value,'>');
    return 'Current value: ' + value;
  }
});
</script>
-->

