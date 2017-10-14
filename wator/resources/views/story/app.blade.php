<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Wator Vapor</title>
    <meta name="viewport" content="width=device-width,initial-scale=0.4, maximum-scale=0.4,minimum-scale=0.4, user-scalable=no">
    <link href="//fonts.googleapis.com/earlyaccess/{{ trans('app.font') }}.css" rel="stylesheet" type="text/css">
 
    <!-- jquery -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!-- Latest compiled and minified JavaScript -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
 
    <!--
    <script src="/bower_components/jquery/dist/jquery.min.js"></script>
    <link href="/bower_components/tether/dist/css/tether.min.css" rel="stylesheet" type="text/css">
    <script src="/bower_components/tether/dist/js/tether.min.js"></script>
    <link href="/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/bower_components/kjur-jsrsasign/jsrsasign-latest-all-min.js"></script>
    -->
    
    <script src="/js/ga.js" type="text/javascript"></script>
    <script src="/account/js/login.js" type="text/javascript"></script>
    <script src="/account/js/lang.js" type="text/javascript"></script>
    <script src="/story/js/memo.js" type="text/javascript"></script>
    
    <link href="/css/navi.css" rel="stylesheet" type="text/css">
    <link href="/story/css/app.css" rel="stylesheet" type="text/css">
    <link href="/story/css/mine.css" rel="stylesheet" type="text/css">
    <style>
      body {
        font-size:12pt;
        font-family:'{{trans('app.font_family')}}';
        font-style: normal;
        font-weight: 200;
      }
    </style>
  </head>
  <body>
    @include('navbar')
    @include('hotline')
    @yield('content')
  </body>
</html>
