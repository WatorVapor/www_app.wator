<div class="card card-default text-center">
  <div class="card-body">
    <h1 class="card-title">{{ $phoneme }}</h1>
    <div class="row">
      <div class="col-sm  m-0 p-0">
        <button type="submit" class="btn btn-sm btn-dark rounded-circle">
          <i class="material-icons " style="font-size:12px;color:green;">hearing</i>
        </button>
      </div>
      <div class="col-sm  m-0 p-0">
        <h4 class="rounded-circle">{{ $phoneme }}</h4>
      </div>
      <div class="col-sm  m-0 p-0">
        <button type="submit" class="btn btn-sm btn-dark rounded-circle" onclick="onClickRecordBtn(this)">
          <i class="material-icons " style="font-size:12px;color:red;">mic</i>
        </button>
      </div>
    </div>

    <div class="row">
      <div class="col-sm  m-0 p-0">
        <audio controls="controls" id="wai-recoder-audio-standard">
          <source src="" type="audio/webm">
        </audio>
      </div>
      <div class="col-sm  m-0 p-0">
        <audio controls="controls" id="wai-recoder-audio-train">
          <source src="" type="audio/webm">
        </audio>
      </div>
    </div>


    <div class="row">
      <div class="col-sm  m-0 p-0">
        <canvas id="wai-recoder-canvas-standard"></canvas>
      </div>
      <div class="col-sm  m-0 p-0">
        <canvas id="wai-recoder-canvas-train"></canvas>
      </div>
    </div>

    <div class="row">
    </div>

  </div>
</div>

