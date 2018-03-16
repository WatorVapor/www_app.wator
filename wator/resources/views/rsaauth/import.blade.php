@extends('rsaauth.app')

@section('appnavbar')
  @include('rsaauth.navbar')
@endsection


@section('content')

<div class="row justify-content-md-center">
  <div class="col-md-8 bg-info">
    <textarea id="privateKey" class="text-left small" rows="40">
      -----BEGIN PRIVATE KEY-----
      -----BEGIN PUBLIC KEY-----
    </textarea>
   </div>
</div>

<script>
  $(document).ready(function() {
  });
</script>
@endsection
