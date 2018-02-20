<div class="card card-default text-center">
  <div class="card-body">
    <h1 class="card-title">{{ $phoneme }}</h1>
    
    <div class="row">
      <div class="col  m-0 p-0">
        <button type="submit" class="btn btn-lg btn-outline-dark rounded-circle">
          <i class="material-icons " style="font-size:24px;color:green;">hearing</i>
        </button>
      </div>
      <div class="col  m-0 p-0">
        <button type="submit" class="btn btn-lg btn-outline-dark rounded-circle" onclick="onClickRecordBtn(this)">
          <i class="material-icons " style="font-size:24px;color:red;">mic</i>
        </button>
        <div class="progress">
          <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
        </div>
      </div>
    </div>

    <div class="row d-none">
      <div class="col  m-0 p-0">
        <audio controls="controls" id="wai-recoder-audio-standard">
          <source src="" type="audio/webm">
        </audio>
      </div>
      <div class="col  m-0 p-0">
        <audio controls="controls" id="wai-recoder-audio-train">
          <source src="" type="audio/webm">
        </audio>
      </div>
    </div>

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

