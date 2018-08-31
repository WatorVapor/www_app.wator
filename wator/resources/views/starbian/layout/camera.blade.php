<div class="row mt-lg-5 justify-content-center">
  <div class="col-10" id="vue-ui-remote-device-keys">
    <div class="row mt-lg-5 justify-content-center" v-for="remote in remoteDeviceKeys">
      <div class="col-1">
        <a type="button" class="btn btn-primary btn-block"
          v-bind:href="remote.casturl" target="_blank">
          <i class="material-icons">videocam</i>
        </a>
      </div>
      <div class="col-1">
        <a type="button" class="btn btn-success btn-block"
          v-bind:href="remote.rcvurl" target="_blank">
          <i class="material-icons">video_call</i>
        </a>
      </div>
      <div class="col-1">
        <a type="button" class="btn btn-danger btn-block" onclick="onRemoveRemoteKey(this)">
          <i class="material-icons">remove_circle</i>
        </a>
      </div>
      <div class="col-8">
        <span class="label label-info d-inline-block text-truncate" >@{{ remote.key }}</span>
      </div>
    </div>
  </div>
</div>
