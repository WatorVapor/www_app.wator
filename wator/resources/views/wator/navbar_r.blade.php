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


<ul class="navbar-nav justify-content-end">
  <li class="nav-item active mr-lg-3">
    <a tabindex="0" href="#" class="btn btn-lg btn-success nav-btn" data-container="body" data-html="true" data-trigger="focus" data-toggle="popover" data-placement="bottom" data-content="{{ $langs }}">
      <i class="material-icons md-48">language</i>
    </a>
  </li>
  <li class="nav-item active">
    <a tabindex="1" href="#" class="btn btn-lg btn-success nav-btn" data-container="body" data-html="true" data-trigger="focus" data-toggle="popover" data-placement="bottom" data-content="{{ $apps }}">
      <i class="material-icons md-48">apps</i>
    </a>
  </li>
</ul>

