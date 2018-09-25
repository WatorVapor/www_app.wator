<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=0.35, maximum-scale=0.35,minimum-scale=0.35">
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
    <title>Wator</title>
    @include('wator.app_css')
  </head>
  <body>
    @include('wator.app_js')
    <div class="container-fluid">
      @yield('content')
    </div>
  </body>
</html>
