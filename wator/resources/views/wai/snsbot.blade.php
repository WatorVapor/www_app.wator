<!doctype html>
<?php
  $img_url= '';
  $input_text= '';
  $result_text= '';
  foreach ($result as $sentence) {
    if(isset($sentence['graph'])) {
      if(!$img_url) {
      $img_url= 'https://www.wator.xyz/' . $sentence['graph'] . '.png';
      }
    } 
    if(isset($sentence['input'])) {
      $input_text .= $sentence['input'];
    }
    if(isset($sentence['sentence'])) {
      $result_text .= $sentence['sentence'];
    }
  }
?>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=0.35, maximum-scale=0.35,minimum-scale=0.35">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@username" />
    <meta name="twitter:creator" content="@username" />
    <meta property="og:title" content="{{ trans('wai_participle.card_result') }}:  {{ $result_text }}" />
    <meta property="og:description" content="{{ trans('wai_participle.card_input') }}:  {{ $input_text }}" />
    <meta property="og:url" content="https://www.wator.xyz/wai/text/participle" />
    <meta property="og:image" content="{{ $img_url }}"/> 

    <title>Wator</title>
    <!-- Fonts -->
    <link href="//fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"  integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/flag-icon-css/2.8.0/css/flag-icon.css" integrity="sha256-uNjm68xPD+6gnVc/JWO6c0TgsEu/PqsXTc9djrPqhOw=" crossorigin="anonymous" />
    </style>
    
  </head>
  <body>
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-lg-10">
          @foreach ($result as $sentence)
          <div class="card card-default text-center border border-danger">
            <div class="card-body">
              <img class="card-img-bottom" src="{{ $sentence['graph'] }}.png" alt="Card image cap">
            </div>
            <div class="card-footer">
              <a href="{{ $sentence['graph'] }}.svg" target="_blank" class="btn btn-primary">{{ trans('wai_participle.opencleargraph') }}</a>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </body>
</html>
