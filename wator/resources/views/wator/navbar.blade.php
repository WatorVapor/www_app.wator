<?php
  $langs = '';
  $langs .= '<a class="btn btn-success" onclick="onClickLanguage(\'zh\')" role="button">';
  $langs .= '<span class="flag-icon flag-icon-background flag-icon-cn"></span>';
  $langs .= '</a>';
  $langs .= '<a class="btn btn-success" onclick="onClickLanguage(\'ja\')" role="button">';
  $langs .= '<span class="flag-icon flag-icon-background flag-icon-jp"></span>';
  $langs .= '</a>';
  $langs .= '<br/>';
  $langs .= '<a class="btn btn-success" onclick="onClickLanguage(\'en\')" role="button">';
  $langs .= '<span class="flag-icon flag-icon-background flag-icon-us"></span>';
  $langs .= '</a>';
  $langs .= '<a class="btn btn-success" onclick="onClickLanguage(\'ru\')" role="button">';
  $langs .= '<span class="flag-icon flag-icon-background flag-icon-ru"></span>';
  $langs .= '</a>';
?>
<?php
  $apps = '';
  $apps .= '<a class="btn btn-lg btn-success" href="/xuniverse" role="button">';
  $apps .= '<i class="material-icons md-48">filter_vintage</i>';
  $apps .= '</a>';
  $apps .= '<a class="btn btn-lg btn-success" href="/p2pio" role="button">';
  $apps .= '<i class="material-icons md-48">device_hub</i>';
  $apps .= '</a>';
  $apps .= '<a class="btn btn-lg btn-success" href="/story" role="button">';
  $apps .= '<i class="material-icons md-48">book</i>';
  $apps .= '</a>';
  $apps .= '<hr/>';
  $apps .= '<a class="btn btn-lg btn-success" href="/wai" role="button">';
  $apps .= '<i class="material-icons md-48">mic</i>';
  $apps .= '</a>';
  $apps .= '<a class="btn btn-lg btn-success" href="/scope" role="button">';
  $apps .= '<i class="material-icons md-48">photo</i>';
  $apps .= '</a>';
?>


<nav class="navbar fixed-top navbar-toggleable navbar-light bg-faded" role="navigation">
  <div class="container">
    <div class="nav navbar-nav navbar-left collapse navbar-collapse">
      <a class="btn btn-lg btn-primary" href="/" role="button">
        <i class="material-icons md-48">home</i>
      </a>
      <a class="btn btn-lg btn-primary" href="/about" role="button">
        <i class="material-icons md-48">info</i>
      </a>
    </div>	
    <div class="nav navbar-nav navbar-right collapse navbar-collapse">
      <a tabindex="0" href="#" class="btn btn-lg btn-success" data-container="body" data-html="true" data-trigger="focus" data-toggle="popover" data-placement="bottom" data-content="{{ $langs }}">
        <i class="material-icons md-48">language</i>
      </a>
      <a tabindex="1" href="#" class="btn btn-lg btn-success" data-container="body" data-html="true" data-trigger="focus" data-toggle="popover" data-placement="bottom" data-content="{{ $apps }}">
        <i class="material-icons md-48">apps</i>
      </a>
      @if(isset($RSAAuth_Passed))
      <a tabindex="2" href="#" role="button" class="btn btn-lg btn-success" data-container="body" data-html="true" data-trigger="focus" data-toggle="popover" data-placement="bottom" title="{{ $user_title }}" data-content="{{ $user }}">
        <i class="material-icons md-48">person</i>
        <span class="icon-bar">{{ mb_substr($nav_login_show_name,0,2,'UTF-8') }}</span>
      </a>
      @else
      <a role="button" class="btn btn-success btn-lg" href="/account/signup" role="button">
        <i class="material-icons md-48">person_add</i>
      </a>
      @endif
    </div>
  </div>
  <script>
    $('[data-toggle="popover"]').popover();
  </script>
</nav>
