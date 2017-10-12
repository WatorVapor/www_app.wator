<?php
  $bluetooths = '';
  $bluetooths .= '<div class="row justify-content-around mt-lg-3 ml-lg-4 mr-lg-4">';
  $bluetooths .= '<a class="btn btn-lg btn-success mr-lg-5 " href="/ppio/ble/dbc" role="button">';
  $bluetooths .= '<i class="material-icons md-48">directions_car</i>';
  $bluetooths .= '</a>';
  $bluetooths .= '<a class="btn btn-lg btn-success mr-lg-5" href="/ppio/ble/chart" role="button">';
  $bluetooths .= '<i class="material-icons md-48">timeline</i>';
  $bluetooths .= '</a>';
  $bluetooths .= '</div>';
?>


<ul class="navbar-nav nav justify-content-center">
  <li class="nav-item active ml-lg-3">
    <a class="btn btn-lg btn-danger " href="/ppio" role="button">
      <i class="material-icons md-48">help_outline</i>
    </a>
  </li>
  <li class="nav-item active ml-lg-3">
    <a tabindex="0" href="#" class="btn btn-lg btn-success nav-btn" data-container="body" data-html="true" data-trigger="focus" data-toggle="popover" data-placement="bottom" data-content="{{ $bluetooths }}">
      <i class="material-icons md-48">bluetooth</i>
    </a>
  </li>
</ul>
