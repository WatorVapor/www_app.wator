<?php
  $langs = '';
  $langs .= '<a class="btn btn-success mr-lg-3" onclick="onClickLanguage(\'zh\')" role="button">';
  $langs .= '<span class="flag-icon flag-icon-background flag-icon-cn"></span>';
  $langs .= '</a>';
  $langs .= '<a class="btn btn-success mr-lg-3" onclick="onClickLanguage(\'ja\')" role="button">';
  $langs .= '<span class="flag-icon flag-icon-background flag-icon-jp"></span>';
  $langs .= '</a>';
  $langs .= '<br/>';
  $langs .= '<a class="btn btn-success mr-lg-3 mt-lg-3" onclick="onClickLanguage(\'en\')" role="button">';
  $langs .= '<span class="flag-icon flag-icon-background flag-icon-us"></span>';
  $langs .= '</a>';
  $langs .= '<a class="btn btn-success mr-lg-3 mt-lg-3" onclick="onClickLanguage(\'ru\')" role="button">';
  $langs .= '<span class="flag-icon flag-icon-background flag-icon-ru"></span>';
  $langs .= '</a>';
?>
<?php
  $apps = '';
  $apps .= '<a class="btn btn-lg btn-success mr-lg-3" href="/xuniverse" role="button">';
  $apps .= '<i class="material-icons md-48">filter_vintage</i>';
  $apps .= '</a>';
  $apps .= '<a class="btn btn-lg btn-success mr-lg-3" href="/p2pio" role="button">';
  $apps .= '<i class="material-icons md-48">device_hub</i>';
  $apps .= '</a>';
  $apps .= '<a class="btn btn-lg btn-success mr-lg-3" href="/story" role="button">';
  $apps .= '<i class="material-icons md-48">book</i>';
  $apps .= '</a>';
  $apps .= '<hr/>';
  $apps .= '<a class="btn btn-lg btn-success mr-lg-3" href="/wai" role="button">';
  $apps .= '<i class="material-icons md-48">mic</i>';
  $apps .= '</a>';
  $apps .= '<a class="btn btn-lg btn-success mr-lg-3" href="/scope" role="button">';
  $apps .= '<i class="material-icons md-48">photo</i>';
  $apps .= '</a>';
?>

<?php
  $user_title= 'guest';
  if( isset($nav_login_show_name)) {
    $user_title = $nav_login_show_name;
  }
  $user = '';
  $user .= '<a class="btn btn-lg btn-success" href="/account/profile" role="button">';
  $user .= '<i class="material-icons md-48">account_box</i>';
  $user .= '</a>';
?>


<ul class="navbar-nav justify-content-end">
  <li class="nav-item active mr-lg-4">
    <a tabindex="0" href="#" class="btn btn-lg btn-success nav-btn" data-container="body" data-html="true" data-trigger="focus" data-toggle="popover" data-placement="bottom" data-content="{{ $langs }}">
      <i class="material-icons md-48">language</i>
    </a>
  </li>
  <li class="nav-item active mr-lg-4">
    <a tabindex="1" href="#" class="btn btn-lg btn-success nav-btn" data-container="body" data-html="true" data-trigger="focus" data-toggle="popover" data-placement="bottom" data-content="{{ $apps }}">
      <i class="material-icons md-48">apps</i>
    </a>
  </li>
  @if(isset($RSAAuth_Passed))
  <li class="nav-item active">
    <a tabindex="2" href="#" role="button" class="btn btn-lg btn-success" data-container="body" data-html="true" data-trigger="focus" data-toggle="popover" data-placement="bottom" title="{{ $user_title }}" data-content="{{ $user }}">
      <i class="material-icons md-48">person</i>
      <span class="icon-bar">{{ mb_substr($nav_login_show_name,0,2,'UTF-8') }}</span>
    </a>
  </li>
  @else
  <li class="nav-item active">
    <a role="button" class="btn btn-success btn-lg" href="/account/signup" role="button">
      <i class="material-icons md-48">person_add</i>
    </a>
  </li>
  @endif
</ul>
