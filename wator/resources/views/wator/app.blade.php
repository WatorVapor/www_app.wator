<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=0.35, maximum-scale=0.35,minimum-scale=0.35">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Wator</title>
    <!-- Fonts -->
    <link href="//fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/flag-icon-css/2.8.0/css/flag-icon.css" integrity="sha256-uNjm68xPD+6gnVc/JWO6c0TgsEu/PqsXTc9djrPqhOw=" crossorigin="anonymous" />
    <style type="text/css">
      .popover {
        max-width: 400px !important;
      }
    </style>
    
  </head>
  <body>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsrsasign/8.0.4/jsrsasign-all-min.js" type="text/javascript"></script>
    <script src="/wator/js/clipboard.min.js" type="text/javascript"></script>
    <script src="/wator/js/ga.js" type="text/javascript"></script>
    <script src="/wator/js/login.js" type="text/javascript"></script>
    <script src="/wator/js/lang.js" type="text/javascript"></script>
    
    <nav class="navbar navbar-fixed-top navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        @include('wator.navbar_l')
        @yield('appnavbar')
        @include('wator.navbar_r')
      </div>
      <script>
        $('[data-toggle="popover"]').popover({container: 'body' });
      </script>
    </nav>
    <div class="container-fluid">
      @yield('content')
    </div>
    <div id="rsa.login.session.auto" hidden> {{ $RSAAuth_AutoLogin}} </div>
    <div id="rsa.login.session.access" hidden> {{ $RSAAuth_Access}} </div>    
  </body>
</html>
