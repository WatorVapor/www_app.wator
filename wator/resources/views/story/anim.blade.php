<div class="container-fluid">
  <div class="row">
    <div class="col-md-11 col-md-offset-1">
      @foreach($anim as $img)
      <a href="/repository/{{ $img }}">
        <img height="120"src="/repository/{{ $img }}">
      </a>
      @endforeach
    </div>
  </div>
</div>
