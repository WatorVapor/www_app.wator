<!doctype html>
<html lang="{{ app()->getLocale() }}">
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
    @include('wator.app_css')
  </head>
  <body>
    @include('wator.app_js')
    <script src="//tjs.sjs.sinajs.cn/open/api/js/wb.js" type="text/javascript" charset="utf-8"></script>
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
    
      <div class="container-fluid">
        <wb:like appkey="6LaDWs"></wb:like>
      </div>
    </footer>
  </body>
</html>
