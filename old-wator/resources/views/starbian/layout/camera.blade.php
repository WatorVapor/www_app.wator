<div class="row mt-lg-5 justify-content-center">
  <div class="col-3" >
    <label class="checkbox-inline">
      <input type="checkbox" id="ui-auto-goto-cast"  value="" onclick="onClickAutoGotoCast(this)">
      Auto Goto Cast
    </label>
  </div>
  <div class="col-3">
    @if (isset($mobile))
    <a type="button" class="btn btn-primary btn-lg btn-block" id="ui-btn-goto-cast"
      href="https://www.wator.xyz/starbian/cloud/m/videocam_cast" target="_blank">
      <i class="material-icons">videocam</i>
      <b>Cast to All</b>
    </a>
    @else
    <a type="button" class="btn btn-primary btn-block" id="ui-btn-goto-cast"
      href="https://www.wator.xyz/starbian/cloud/videocam_cast" target="_blank">
      <i class="material-icons">videocam</i>
      <b>Cast to All</b>
    </a>
    @endif
  </div>
  <div class="col-3">
    @if (isset($mobile))
    <a type="button" class="btn btn-primary btn-lg btn-block" id="ui-btn-goto-monitor"
      href="https://www.wator.xyz/starbian/cloud/m/videocam_monitor" target="_blank">
      <i class="material-icons">ring_volume</i>
      <b>Wait From All</b>
    </a>
    @else
    <a type="button" class="btn btn-primary btn-block" id="ui-btn-goto-monitor"
      href="https://www.wator.xyz/starbian/cloud/videocam_monitor" target="_blank">
      <i class="material-icons">ring_volume</i>
      <b>Wait From All</b>
    </a>
    @endif
  </div>
</div>
<hr/>
<div class="row mt-lg-5 justify-content-center">
  <div class="col-10" id="vue-ui-remote-device-keys">
    <div class="row mt-lg-5 justify-content-center" v-for="remote in remoteDeviceKeys">
      <div class="col-2">
        @if (isset($mobile))
        <a type="button" class="btn btn-primary btn-lg btn-block"
          v-bind:href="remote.casturl" target="_blank">
          <i class="material-icons">videocam</i>
        </a>
        @else
        <a type="button" class="btn btn-primary btn-block"
          v-bind:href="remote.casturl" target="_blank">
          <i class="material-icons">videocam</i>
        </a>
        @endif
      </div>
      <div class="col-2">
        @if (isset($mobile))
        <a type="button" class="btn btn-success btn-lg btn-block"
          v-bind:href="remote.rcvurl" target="_blank">
          <i class="material-icons">video_call</i>
        </a>
        @else
        <a type="button" class="btn btn-success btn-block"
          v-bind:href="remote.rcvurl" target="_blank">
          <i class="material-icons">video_call</i>
        </a>
        @endif
      </div>
      <div class="col-2">
        @if (isset($mobile))
        <a type="button" class="btn btn-danger btn-lg btn-block" onclick="onRemoveRemoteKey(this)">
        @else
        <a type="button" class="btn btn-danger btn-block" onclick="onRemoveRemoteKey(this)">
        @endif
          <i class="material-icons">remove_circle</i>
        </a>
      </div>
      <div class="col-6">
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
<script type="text/javascript">
  $(document).ready(function() {
    let autogotoCast = localStorage.getItem(LS_AUTO_GOTO_CAST_NAME);
    let elemCheck = document.getElementById('ui-auto-goto-cast');
    if(autogotoCast === 'true') {
      elemCheck.checked = true;
      setTimeout(() => {
        GotoCast();
      },30000)
    } else {
      elemCheck.checked = false;
    }
  });
  const LS_AUTO_GOTO_CAST_NAME = 'wator-starbian-auto-goto-cast';
  function onClickAutoGotoCast(elem) {
    console.log('onClickAutoGotoCast elem=<' , elem , '>');
    console.log('onClickAutoGotoCast elem.checked=<' , elem.checked , '>');
    localStorage.setItem(LS_AUTO_GOTO_CAST_NAME,elem.checked);
  }
  function GotoCast() {
    let elemBtn = document.getElementById('ui-btn-goto-cast');
    if(elemBtn) {
      elemBtn.click();
    }
  }
</script>
