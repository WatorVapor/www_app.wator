@php
$phonemeTable = [
'あ','い','う','え','お',
]
static $phonemeIndex = 0;
$phoneme = $phonemeTable[$phonemeIndex++];
@endphp
<div class="row">
  <div class="col">{{phoneme}}</div>
  <div class="col">
    <button type="submit" value="cn" name="lang" class="btn btn-block btn-primary">
      <i class="material-icons md-48">hearing</i>
    </button>
  </div>
  <div class="col">
    <button type="submit" value="cn" name="lang" class="btn btn-block btn-primary">
      <i class="material-icons md-48">mic</i>
    </button>
  </div>
</div>

