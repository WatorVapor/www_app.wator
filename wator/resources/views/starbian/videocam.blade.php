@extends('wator.app')
@section('appnavbar')
  @include('starbian.navbar')
@endsection

@section('content')
<hr/>
<div class="row mt-lg-5 justify-content-center">
  <div class="col-5">
    <div class="card card-default text-center bg-secondary">
      <div class="card-header">
        My Public key
      </div>
      <div class="card-body">
        <pre class="card-text text-danger" id="text-this-device-key" rows="40" style="white-space: pre-wrap ;">@{{ pub_key }}</pre>
        <br/>
        <button type="button" class="btn btn-primary btn-sm  pull-right btn-clipboard" id="btn-copy-key" data-clipboard-target="#text-this-device-key">Copy</button>
        <button type="button" class="btn btn-primary btn-sm  pull-left" id="btn-share-key" onclick="onSharedPubKey(this)">
          <i class="material-icons">dialpad</i><i class="material-icons">share</i>
        </button>
        <h1 class="ml-lg-1 pull-left bg-success text-danger" id="text-share-key-onetime-password">8182</h1>
        <h4 class="ml-lg-5 pull-left" id="text-share-key-count-down">100</h4>
      </div>
    </div>
  </div>
  <div class="col-5">
    <div class="card card-default text-center bg-info">
      <div class="card-header">
        Camera Public key
      </div>
      <div class="card-body">
        <textarea class="form-control input-sm" id="text-remote-device-key" rows="3" ></textarea>
        <br/>
        <button type="button" class="btn btn-success btn-sm" id="btn-add-key" onclick="onAddRemoteKey(this)">+ Key for remote for Camera</button>
      </div>
    </div>
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
        <span class="label label-info d-inline-block text-truncate" >@{{ remote.key }}</span>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  new Clipboard('.btn-clipboard');
</script>

<script type="text/javascript">
  function onUpdatePublicKey(key) {
    console.log('onUpdatePublicKey key=<' , key , '>');
    let app1 = new Vue({
      el: '#text-this-device-key',
      data: {
          pub_key: key
      }
    });
  }
</script>


<script type="text/javascript">
  function onAddRemoteKey(elem) {
    try {
      console.log('onAddRemoteKey elem=<' , elem , '>');
      let root = elem.parentElement;
      console.log('onAddRemoteKey root=<' , root , '>');
      let textKey = root.getElementsByTagName('textarea')[0].value;
      console.log('onAddRemoteKey textKey=<' , textKey , '>');
      if(textKey) {
        WATOR.addRemoteKey(textKey.trim());
      }
    } catch(e) {
      console.error(e);
    }
  }
</script>

<script type="text/javascript">
  function onRemoteKeyRead() {
    let remotekeys = WATOR.getRemoteKeys();
    console.log('onRemoteKeyRead remotekeys=<' , remotekeys , '>');
    let urls = [];
    for(let i = 0;i < remotekeys.length ; i++) {
      let casturl = 'https://www.wator.xyz/starbian/cloud/videocam/' + remotekeys[i];
      let rcvurl = 'https://www.wator.xyz/starbian/cloud/videocam_recv/' + remotekeys[i];
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
  function onStartVidoeCam (elem) {
    try {
      console.log('onStartVidoeCam elem=<' , elem , '>');
      let textContent = elem.textContent;
      console.log('onStartVidoeCam textContent=<' , textContent , '>');
      if(textContent) {
        let textKey = textContent.replace('Connect to Camera ','');
        console.log('onStartVidoeCam textKey=<' , textKey , '>');
        WATOR.connect(textKey.trim());
      }
    } catch(e) {
      console.error(e);
    }
  }
  function onRemoveRemoteKey (elem) {
    try {
      console.log('onRemoveRemoteKey elem=<' , elem , '>');
      let keyElem = elem.parentElement.parentElement.getElementsByTagName('span')[0];
      console.log('onRemoveRemoteKey keyElem=<' , keyElem , '>');
      let textKey = keyElem.textContent;
      console.log('onRemoveRemoteKey textKey=<' , textKey , '>');
      if(textKey) {
        console.log('onRemoveRemoteKey textKey=<' , textKey , '>');
        WATOR.removeKey(textKey.trim());
      }
    } catch(e) {
      console.error(e);
    }
  }
</script>


@include('starbian.js.keys')
@include('starbian.js.videocam')
@endsection
