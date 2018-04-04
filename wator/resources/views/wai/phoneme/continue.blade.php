<style>
body {
  font-family:'{{trans('app.font_family')}}';
}
</style>


<div class="d-none" >
  <form method="POST" action="#" accept-charset="utf-8">
    {{ csrf_field() }}
    <div class="form-group d-none">
      <input type="text" name="phoneme" value="{{ $phoneme }}" />
      <input type="text" name="lang" value="{{ $lang }}" />
    </div>
    <button type="submit" id="wai-recoder-clip-done-next"></button>
  </form>
</div>

<div class="d-none" >
  <form method="POST" action="#" accept-charset="utf-8">
    {{ csrf_field() }}
    <div class="form-group d-none">
      <input type="text" id="wai-recoder-clip-ipfs" name="ipfs" value="ipfs" />
    </div>
    <button type="submit" id="wai-recoder-clip-ipfs-submit"></button>
  </form>
</div>


<div class="card card-default text-center">
  <div class="card-body">
    <div class="row">
      <div class="col-2  m-0 p-0"></div>
      <div class="col-8  m-0 p-0">
        <h1 class="card-title" style="font-size:96px;">{{ $phoneme }}</h1>
      </div>
      <div class="col-2  m-0 p-0" id="wai-recoder-clip-upload">
        <button type="submit" class="btn btn-lg btn-outline-dark rounded-circle" style="height:96px;width:96px;" onclick="onClickUploadBtn(this)">
          <i class="material-icons " style="font-size:60px;color:green;">cloud_upload</i>
          <span class="badge badge-light" id="wai-recoder-clip-in-local">0</span>
        </button>
      </div>
      <div class="col-2  m-0 p-0 d-none" id="wai-recoder-clip-animate">
          <i class="fa fa-spinner fa-spin" style="font-size:96px;color:red"></i>
      </div>
    </div>
    <h6 class="card-title" style="font-size:18px;">{{ $finnish }}/{{ $total }}</h6>
    <pre class="card-title" style="font-size:48px;color:red;">{{ $phoneme_help }}</pre>
    
    <div class="row">
      <div class="col  m-0 p-0">
       @empty($ipfs)
        <button type="submit" class="btn btn-lg btn-outline-dark rounded-circle" style="height:96px;width:96px;" disabled>
        @else
        <button type="submit" class="btn btn-lg btn-outline-dark rounded-circle" style="height:96px;width:96px;" onclick="onClickHearingBtn(this)">
        @endempty
          <i class="material-icons " style="font-size:60px;color:green;">hearing</i>
        </button>
      </div>
      <div class="col  m-0 p-0 d-none" id="wai-recoder-clip-done">
        <button type="submit" class="btn btn-lg btn-outline-dark rounded-circle" style="height:96px;width:96px;" onclick="onClickDoneBtn(this)">
          <i class="material-icons " style="font-size:60px;color:green;">done</i>
        </button>
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
        <audio controls id="wai-recoder-audio-train">
          <source src="" type="audio/webm">
        </audio>
      </div>
    </div>

    <hr/>


    <div class="row">
      <div class="col  m-0 p-0">
        <img  id="wai-recoder-canvas-standard"></img >
      </div>
    </div>

    <div class="row">
      <div class="col  m-0 p-0">
        <img  id="wai-recoder-canvas-train"></img >
      </div>
    </div>

  </div>
</div>
