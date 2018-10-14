<div class="row mt-lg-2 justify-content-center">
  <div class="col-5">
    <div class="card card-default text-center bg-secondary">
      <div class="card-header">
        My Public key
      </div>
      <div class="card-body">
        <pre class="card-text text-success" id="text-this-device-key" style="white-space: pre-wrap ; font-size: x-large;">
          @{{ pub_key }}
        </pre>
        <button type="button" class="btn btn-primary btn-sm mt-sm-1 pull-right btn-clipboard" id="btn-copy-key" data-clipboard-target="#text-this-device-key">Copy</button>
        <button type="button" class="btn btn-success btn-sm mt-sm-1 pull-left" id="btn-qrcode-key" onclick="onQRCodePubKey(this)">QRCode</button>
        <br/>
        <button type="button" class="btn btn-warning btn-sm pull-left mt-sm-3" id="btn-share-key" onclick="onSharedPubKey(this)">
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
        <textarea class="form-control input-sm" id="text-remote-device-key" rows="5" ></textarea>
        <br/>
        <p class="d-none pull-left bg-warning" id="text-share-key-onetime-password-verified-counter"></p>
        <button type="button" class="btn btn-success btn-sm pull-right" id="btn-add-key" onclick="onAddRemoteKey(this)">+ Key of remote Device</button>
      </div>
      <div class="card-body">
        <div class="input-group mb-xs-1">
          <input type="text" class="form-control" placeholder="password show on remote device" aria-label="one time password" aria-describedby="button-addon2">
          <div class="input-group-append">
            <button class="btn btn-danger btn-sm" type="button" onclick="onSearchPubKey(this)" id="button-addon2"><i class="material-icons">search</i></button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js" 
  integrity="sha256-9MzwK2kJKBmsJFdccXoIDDtsbWFh8bjYK/C7UjB1Ay0=" crossorigin="anonymous">
</script>

<script type="text/javascript">
  new ClipboardJS('.btn-clipboard');
</script>

<script type="text/javascript">
  StarBian.onReadyOfKey = (key) => {
    console.log('StarBian.onReadyOfKey key=<' , key , '>');
    onUpdatePublicKey(key);
  };
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
        StarBian.addRemoteKey(textKey.trim());
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
        StarBian.removeKey(textKey.trim());
      }
    } catch(e) {
      console.error(e);
    }
  }
</script>

<script type="text/javascript">
let broadcastKey = new StarBian.BroadCast();
broadcastKey.isReady = false;
broadcastKey.onReady = () => {
  broadcastKey.isReady = true;
};


function onSharedPubKey (elem) {
  try {
    console.log('onSharedPubKey  elem=<' , elem , '>');
    elem.setAttribute('disabled','true');
    broadcastKey.broadcastPubKey( (status,password) => {
      console.log('onSharedPubKey status=<' , status , '>');
      if(status < 1) {
        elem.setAttribute('disabled','false');
        $("#text-share-key-onetime-password").addClass("d-none");
        $("#top-share-key-onetime-progress").addClass("d-none");
        return;
      }
      if(password) {
        $("#text-share-key-onetime-password").text(password);
      }
      $("#text-share-key-onetime-password").removeClass("d-none");
      $("#text-share-key-onetime-password").toggleClass('bg-success');
      
      
      $("#text-share-key-onetime-progress").text(status *10);
      $("#text-share-key-onetime-progress").attr('style','width: ' + status *10 + '%');
      $("#text-share-key-onetime-progress").attr('aria-valuenow',status *10);
      $("#top-share-key-onetime-progress").removeClass("d-none");
      console.log('onSharedPubKey password=<' , password , '>');
    });
  } catch(e) {
    console.error(e);
  }
}

function onSearchPubKey (elem) {
  try {
    //console.log('onSearchPubKey  elem=<' , elem , '>');
    let root = elem.parentElement.parentElement;
    //console.log('onSearchPubKey root=<' , root , '>');
    let textPassword = root.getElementsByTagName('input')[0].value;
    //console.log('onSearchPubKey textPassword=<' , textPassword , '>');
    if(!textPassword) {
      return;
    }
    broadcastKey.listenPubKey(textPassword.trim(), (pubKey,verified) => {
      console.log('onSearchPubKey pubKey=<' , pubKey , '>');
      console.log('onSearchPubKey verified=<' , verified , '>');
      $("#text-share-key-onetime-password-verified-counter").removeClass("d-none");
      $("#text-share-key-onetime-password-verified-counter").text( 'This password  is verified ' + verified + ' Times');
      $("#text-remote-device-key").text(pubKey);
    });
  } catch(e) {
    console.error(e);
  }
}
</script>
