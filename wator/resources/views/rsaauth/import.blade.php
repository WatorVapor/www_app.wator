@extends('rsaauth.app')

@section('appnavbar')
  @include('rsaauth.navbar')
@endsection


@section('content')

<div class="row justify-content-center" style="height:20px;">
</div>

<div class="row justify-content-center">
  <div class="col-8">
    <textarea id="importKey" class="w-100 text-left small" rows="10" data-toggle="tooltip" data-placement="bottom" title="paste -----BEGIN PRIVATE KEY----- -----BEGIN PUBLIC KEY-----">
    </textarea>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>
@endsection
