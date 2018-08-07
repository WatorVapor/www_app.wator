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
    <div class="row ml-lg-5 justify-content-center">
      <div class="col-8">
        <span v-for="remote in remoteDeviceKeys" class="badge label label-info">@{{ remote.key }}</span>
      </div>
    </div>
    <div class="row ml-lg-5 justify-content-center">
      <div class="col-1">
        <a type="button" v-for="remote in remoteDeviceKeys" class="btn btn-success btn-block"
          v-bind:href="remote.url" target="_blank">
          <i class="material-icons">videocam</i>
        </a>
      </div>
      <div class="col-1">
        <a type="button" v-for="remote in remoteDeviceKeys" class="btn btn-success btn-block"
          v-bind:href="remote.url" target="_blank">
          <i class="material-icons">video_call</i>
        </a>
      </div>
      <div class="col-1">
        <a type="button" v-for="remote in remoteDeviceKeys" class="btn btn-success btn-block"
          v-bind:href="remote.url" target="_blank">
          <i class="material-icons">remove_circle</i>
        </a>
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
    let urls = [];
    for(let i = 0;i < remotekeys.length ; i++) {
      let url = 'https://www.wator.xyz/starbian/cloud/videocam/' + remotekeys[i];
      let keyPairs = {key:remotekeys[i],url:url}
      urls.push(keyPairs);
    }
    console.log('onRemoteKeyRead remotekeys=<' , remotekeys , '>');
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
</script>


@include('starbian.js.keys')
@include('starbian.js.videocam')
@endsection
