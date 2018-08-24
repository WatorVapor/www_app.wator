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
        GoFuro Public key
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
  function onRemoteKeyRead() {
    let remotekeys = WATOR.getRemoteKeys();
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
@include('starbian.js.gofuro')
@endsection
