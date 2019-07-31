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
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        @include('wator.navbar_l')
        @yield('appnavbar')
        @include('wator.navbar_r')
      </div>
      <script>
        $('[data-toggle="popover"]').popover({container: 'body' });
      </script>
    </nav>
    <div class="container-fluid mt-5 pt-3">
      @yield('content')
    </div>
    <a class="d-none" href="/search/link"/>;
  </body>
</html>
