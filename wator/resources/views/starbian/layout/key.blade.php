<div class="row mt-lg-5 justify-content-center">
  <div class="col-5">
    <div class="card card-default text-center bg-secondary">
      <div class="card-header">
        My Public key
      </div>
      <div class="card-body">
        <pre class="card-text text-success" id="text-this-device-key" rows="40" style="white-space: pre-wrap ; font-size: large;">
          @{{ pub_key }}
        </pre>
        <br/>
        <button type="button" class="btn btn-primary btn-sm  pull-right btn-clipboard" id="btn-copy-key" data-clipboard-target="#text-this-device-key">Copy</button>
      </div>
      <div class="card-body">
        <button type="button" class="btn btn-primary btn-warning btn-sm  pull-left" id="btn-share-key" onclick="onSharedPubKey(this)">
          <i class="material-icons">dialpad</i><i class="material-icons">share</i>
        </button>
        <h3 class="ml-lg-3 pull-left bg-success text-danger d-none" id="text-share-key-onetime-password">8182</h3>
        <div class="progress mr-lg-3 d-none" id="top-share-key-onetime-progress">
          <div id="text-share-key-onetime-progress" class="progress-bar progress-bar-striped progress-bar-animated " 
              role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
            100
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-5">
    <div class="card card-default text-center bg-info">
      <div class="card-header">
        Remote Device Public key
      </div>
      <div class="card-body">
        <textarea class="form-control input-sm" id="text-remote-device-key" rows="3" ></textarea>
        <br/>
        <button type="button" class="btn btn-success btn-sm" id="btn-add-key" onclick="onAddRemoteKey(this)">+ Key for remote for Camera</button>
      </div>
      <div class="card-body">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="password show on remote device" aria-label="one time password" aria-describedby="button-addon2">
          <div class="input-group-append">
            <button class="btn btn-danger btn-sm" type="button" onclick="onSearchPubKey(this)" id="button-addon2"><i class="material-icons">search</i></button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  new ClipboardJS('.btn-clipboard');
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

