@extends('rsaauth.app')

@section('appnavbar')
  @include('rsaauth.navbar')
@endsection


@section('content')

<div class="row justify-content-center">
  <div class="col-8 bg-info">
    <textarea id="privateKey" class="w-100 text-left small" rows="40">
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
