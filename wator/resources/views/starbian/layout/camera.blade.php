<div class="row mt-lg-5 justify-content-center">
  <div class="col-3">
    @if (isset($mobile))
    <a type="button" class="btn btn-primary btn-lg btn-block"
      href="https://www.wator.xyz/starbian/cloud/m/videocam_cast" target="_blank">
    @else
    <a type="button" class="btn btn-primary btn-block"
      href="https://www.wator.xyz/starbian/cloud/videocam_cast" target="_blank">
    @endif
      <i class="material-icons">videocam</i>
      <b>Cast to Authed Keys</b>
    </a>
  </div>
</div>
<hr/>
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
        <span class="label label-info d-inline-block text-truncate" style="white-space: pre-wrap ; font-size: large;">@{{ remote.key }}</span>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  function onRemoteKeyRead() {
    let remotekeys = StarBian.getRemoteKey();
    console.log('onRemoteKeyRead remotekeys=<' , remotekeys , '>');
    let urls = [];
    for(let i = 0;i < remotekeys.length ; i++) {
      @if (isset($mobile))
      let casturl = 'https://www.wator.xyz/starbian/cloud/m/videocam_cast/' + remotekeys[i];
      let rcvurl = 'https://www.wator.xyz/starbian/cloud/m/videocam_recv/' + remotekeys[i];
      @else
      let casturl = 'https://www.wator.xyz/starbian/cloud/videocam_cast/' + remotekeys[i];
      let rcvurl = 'https://www.wator.xyz/starbian/cloud/videocam_recv/' + remotekeys[i];
      @endif
      let keyPairs = {
          key:remotekeys[i],
          casturl:casturl,
          rcvurl:rcvurl,
      };
      urls.push(keyPairs);
    }
    let app2 = new Vue({
      el: '#vue-ui-remote-device-keys',
      data: {
          remoteDeviceKeys: urls
      }
    });
  }
  $(document).ready(function(){
    onRemoteKeyRead();
    let elemBtn = document.getElementById('vue-ui-remote-device-keys');
    console.log('onRemoteKeyRead elemBtn=<' , elemBtn , '>');
  });
</script>

