@php
$phoneme = $phonemeTable[$phonemeIndex];
$phonemeIndex = $phonemeIndex + 1;
@endphp
<div class="row">
  <div class="col">{{ $phoneme }}.{{ $phonemeIndex }}</div>
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

