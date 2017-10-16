<!doctype html>
<html lang="{{ app()->getLocale() }}"  xmlns:wb="http://open.weibo.com/wb">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=0.35, maximum-scale=0.35,minimum-scale=0.35">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <meta property="og:type" content="webpage" />
    <meta property="og:url" content="https://www.wator.xyz/" />
    <meta property="og:title" content="Wator" />
    <meta property="og:description" content="Wator Vapor native" />
    <meta property="og:image" content="https://www.wator.xyz/wator/images/home/brain.orig.png" />
    <meta name="weibo:webpage:create_at" content="Mon Oct 16 20:56:50 JST 2016" />
    <meta name="weibo:webpage:update_at" content="Mon Oct 16 20:56:50 JST 2017" />

    
    <title>Wator</title>
    <!-- Fonts -->
    <link href="//fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"  integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/flag-icon-css/2.8.0/css/flag-icon.css" integrity="sha256-uNjm68xPD+6gnVc/JWO6c0TgsEu/PqsXTc9djrPqhOw=" crossorigin="anonymous" />
    <style type="text/css">
      .popover {
        max-width: 400px !important;
      }
    </style>
    
  </head>
  <body>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsrsasign/8.0.3/jsrsasign-all-min.js" type="text/javascript"></script>
    <script src="/wator/js/clipboard.min.js" type="text/javascript"></script>
    <script src="/wator/js/ga.js" type="text/javascript"></script>
    <script src="/wator/js/login.js" type="text/javascript"></script>
    <script src="/wator/js/lang.js" type="text/javascript"></script>
    
    <script src="//tjs.sjs.sinajs.cn/open/api/js/wb.js" type="text/javascript" charset="utf-8"></script>
    

    <nav class="navbar navbar-fixed-top navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        @include('wator.navbar_l')
        @yield('appnavbar')
        @include('wator.navbar_r')
      </div>
      <script>
        //$('[data-toggle="popover"]').popover();
        $('[data-toggle="popover"]').popover({container: 'body' });
      </script>
    </nav>
    <div class="container-fluid">
      @yield('content')
    </div>
    <div id="rsa.login.session.auto" hidden> {{ $RSAAuth_AutoLogin}} </div>
    <div id="rsa.login.session.access" hidden> {{ $RSAAuth_Access}} </div>
    
    <footer class="footer">
      <style type="text/css">
        .footer {
          position: absolute;
          bottom: 0;
          width: 100%;
          /* Set the fixed height of the footer here */
          height: 30px;
          line-height: 30px; /* Vertically center the text there */
          background-color: #f5f5f5;
        }
      </style>
    
      <div class="container">
        <wb:like appkey="6LaDWs"></wb:like>
      </div>
    </footer>    
  </body>
</html>
