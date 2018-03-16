@extends('rsaauth.app')

@section('appnavbar')
  @include('rsaauth.navbar')
@endsection


@section('content')

<div class="row justify-content-center">
  <div class="col-8 bg-info">
    <textarea id="importKey" 
      class="w-100 text-left small" rows="40" 
      data-toggle="tooltip" data-placement="top" title="paste -----BEGIN PRIVATE KEY----- -----BEGIN PUBLIC KEY-----">
    </textarea>
   </div>
</div>

<script>
  $(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>
@endsection
