<?php
  $bluetooths = '';
  $bluetooths .= '<div class="row justify-content-around mt-lg-3 ml-lg-4 mr-lg-4">';
  $bluetooths .= '<a class="btn btn-lg btn-danger mr-lg-5 " href="/ppio/ble/dbc" role="button">';
  $bluetooths .= '<i class="material-icons md-48">directions_car</i>';
  $bluetooths .= '</a>';
  $bluetooths .= '<a class="btn btn-lg btn-danger mr-lg-5" href="/ppio/ble/chart" role="button">';
  $bluetooths .= '<i class="material-icons md-48">timeline</i>';
  $bluetooths .= '</a>';
  $bluetooths .= '</div>';
  $bluetooths .= '<hr/>';
  $bluetooths .= '<div class="row justify-content-around mt-lg-3 ml-lg-4 mr-lg-4">';
  $bluetooths .= '<a class="btn btn-lg btn-danger mr-lg-5 " href="/ppio/ble/search" role="button">';
  $bluetooths .= '<i class="material-icons md-48">bluetooth_searching</i>';
  $bluetooths .= '</a>';
  $bluetooths .= '<a class="btn btn-lg btn-danger mr-lg-5" href="/ppio/ble/raw" role="button" disabled>';
  $bluetooths .= '<i class="material-icons md-48">bug_report</i>';
  $bluetooths .= '</a>';
  $bluetooths .= '</div>';
?>

<?php
  $clouds = '';
  $clouds .= '<div class="row justify-content-around mt-lg-3 ml-lg-4 mr-lg-4">';
  $clouds .= '<a class="btn btn-lg btn-danger mr-lg-5 " href="/ppio/cloud/gofuro" role="button">';
  $clouds .= '<i class="material-icons md-48">hot_tub</i>';
  $clouds .= '</a>';
  $clouds .= '<a class="btn btn-lg btn-danger mr-lg-5" href="/ppio/cloud/chart" role="button" disabled>';
  $clouds .= '<i class="material-icons md-48">timeline</i>';
  $clouds .= '</a>';
  $clouds .= '</div>';
  $clouds .= '<hr/>';
  $clouds .= '<div class="row justify-content-around mt-lg-3 ml-lg-4 mr-lg-4">';
  $clouds .= '<a class="btn btn-lg btn-danger mr-lg-5 " href="/ppio/cloud/search" role="button" disabled >';
  $clouds .= '<i class="material-icons md-48">bluetooth_searching</i>';
  $clouds .= '</a>';
  $clouds .= '<a class="btn btn-lg btn-danger mr-lg-5" href="/ppio/cloud/raw" role="button" disabled>';
  $clouds .= '<i class="material-icons md-48">bug_report</i>';
  $clouds .= '</a>';
  $clouds .= '</div>';
?>



<ul class="navbar-nav nav justify-content-center">
  <li class="nav-item active ml-lg-3">
    <a class="btn btn-lg btn-danger " href="/ppio" role="button">
      <i class="material-icons md-48">help_outline</i>
    </a>
  </li>
  <li class="nav-item active ml-lg-3">
    <a tabindex="0" href="#" class="btn btn-lg btn-danger nav-btn" data-container="body" data-html="true" data-trigger="focus" data-toggle="popover" data-placement="bottom" data-content="{{ $bluetooths }}">
      <i class="material-icons md-48">bluetooth</i>
    </a>
  </li>
  <li class="nav-item active ml-lg-3">
    <a tabindex="0" href="#" class="btn btn-lg btn-danger nav-btn" data-container="body" data-html="true" data-trigger="focus" data-toggle="popover" data-placement="bottom" data-content="{{ $clouds }}">
      <i class="material-icons md-48">cloud</i>
    </a>
  </li>
</ul>
