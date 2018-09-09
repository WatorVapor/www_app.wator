<div class="row mt-lg-5 justify-content-center">
  <div class="col-10" id="vue-ui-remote-device-keys">
    <div class="row mt-lg-5 justify-content-center" v-for="remote in remoteDeviceKeys">
      <div class="col-1">
        <a type="button" class="btn btn-primary btn-block" onclick="onHotupRemoteKey(this)">
          <i class="material-icons">hot_tub</i>
        </a>
      </div>
      <div class="col-1">
        <a type="button" class="btn btn-danger btn-block" onclick="onRemoveRemoteKey(this)">
          <i class="material-icons">remove_circle</i>
        </a>
      </div>
      <div class="col-8">
        <span class="label label-info d-inline-block text-truncate" style="white-space: pre-wrap ; font-size: small;">@{{ remote.key }}</span>
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
      let keyPairs = {
          key:remotekeys[i]
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
  function onHotupRemoteKey (elem) {
    try {
      console.log('onHotupRemoteKey elem=<' , elem , '>');
      let keyElem = elem.parentElement.parentElement.getElementsByTagName('span')[0];
      console.log('onHotupRemoteKey keyElem=<' , keyElem , '>');
      let textKey = keyElem.textContent;
      console.log('onHotupRemoteKey textKey=<' , textKey , '>');
      if(textKey) {
        console.log('onHotupRemoteKey textKey=<' , textKey , '>');
        publishHotUpGofuro(textKey.trim());
      }
    } catch(e) {
      console.error(e);
    }
  }
</script>
