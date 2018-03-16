<?php
  $langs = '';
  $langs .= '<div class="row justify-content-around mt-lg-3 ml-lg-3 mr-lg-3">';
  $langs .= '<a class="btn btn-success mr-lg-5" onclick="onClickLanguage(\'zh\')" role="button">';
  $langs .= '<span class="flag-icon flag-icon-background flag-icon-cn"></span>';
  $langs .= '</a>';
  $langs .= '<a class="btn btn-success " onclick="onClickLanguage(\'ja\')" role="button">';
  $langs .= '<span class="flag-icon flag-icon-background flag-icon-jp"></span>';
  $langs .= '</a>';
  $langs .= '</div>';
  $langs .= '<div class="row justify-content-around mt-lg-5 ml-lg-3 mr-lg-3 mb-lg-3">';
  $langs .= '<a class="btn btn-success mr-lg-5" onclick="onClickLanguage(\'en\')" role="button">';
  $langs .= '<span class="flag-icon flag-icon-background flag-icon-us"></span>';
  $langs .= '</a>';
  $langs .= '<a class="btn btn-success " onclick="onClickLanguage(\'ru\')" role="button">';
  $langs .= '<span class="flag-icon flag-icon-background flag-icon-ru"></span>';
  $langs .= '</a>';
  $langs .= '</div>';
?>
<?php
  $apps = '';
  $apps .= '<div class="row justify-content-around mt-lg-3 ml-lg-4 mr-lg-4">';
  $apps .= '<a class="btn btn-lg btn-success mr-lg-5" href="/starbian" role="button">';
  $apps .= '<i class="material-icons md-48">device_hub</i>';
  $apps .= '</a>';
  $apps .= '<a class="btn btn-lg btn-success disabled" href="/scope" role="button">';
  $apps .= '<i class="material-icons md-48">photo</i>';
  $apps .= '</a>';
  $apps .= '</div>';
  $apps .= '<hr/>';
  $apps .= '<div class="row justify-content-around mt-lg-3 ml-lg-4 mr-lg-4">';
  $apps .= '<a class="btn btn-lg btn-success mr-lg-5 " href="/wai" role="button">';
  $apps .= '<i class="material-icons md-48">mic</i>';
  $apps .= '</a>';
  $apps .= '<a class="btn btn-lg btn-success " href="/story" role="button">';
  $apps .= '<i class="material-icons md-48">book</i>';
  $apps .= '</a>';
  $apps .= '</div>';
?>

<?php
  $user_title= 'guest';
  if( isset($nav_login_show_name)) {
    $user_title = $nav_login_show_name;
  }
  $user = '';
  $user .= '<a class="btn btn-lg btn-success" href="/rsaauth/profile" role="button">';
  $user .= '<i class="material-icons md-48">account_box</i>';
  $user .= '</a>';
  $user .= '<a class="btn btn-lg btn-success" href="/rsaauth/profile" role="button">';
  $user .= '<i class="material-icons md-48">exit_to_app</i>';
  $user .= '</a>';
?>


<ul class="navbar-nav nav justify-content-end">
  <li class="nav-item active mr-lg-5">
    <a tabindex="1" href="#" class="btn btn-lg btn-success nav-btn" data-container="body" data-html="true" data-trigger="focus" data-toggle="popover" data-placement="bottom" data-content="{{ $apps }}">
      <i class="material-icons md-48">apps</i>
    </a>
  </li>
  <li class="nav-item active mr-lg-5">
    <a tabindex="0" href="#" class="btn btn-lg btn-success nav-btn" data-container="body" data-html="true" data-trigger="focus" data-toggle="popover" data-placement="bottom" data-content="{{ $langs }}">
      <i class="material-icons md-48">language</i>
    </a>
  </li>
  @if($RSAAuth_Passed)
  <li class="nav-item active">
    <a tabindex="2" href="#" role="button" class="btn btn-lg btn-warning" data-container="body" data-html="true" data-trigger="focus" data-toggle="popover" data-placement="bottom" title="{{ trans($user_title) }}" data-content="{{ $user }}">
      <i class="material-icons md-48">person</i>
      <span class="icon-bar">{{ mb_substr($user_title,0,2,'UTF-8') }}</span>
    </a>
  </li>
  @else
  <li class="nav-item active">
    <a role="button" class="btn btn-warning btn-lg mr-lg-5" href="/rsaauth/login" role="button">
      <i class="material-icons md-48">person</i>
    </a>
  </li>
  <li class="nav-item active">
    <a role="button" class="btn btn-warning btn-lg" href="/rsaauth/signup" role="button">
      <i class="material-icons md-48">person_add</i>
    </a>
  </li>
  @endif
</ul>
