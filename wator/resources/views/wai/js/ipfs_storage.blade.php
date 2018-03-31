<script type="text/javascript">

class IpfsStorage {
  constructor() {
    this.uriStorage = "wss://" + location.host + "/wator/storage";
    this.wsStorage = new WebSocket(this.uriStorage);
    this.wsStorage.onopen = onStorageOpen_.bind(this);
    this.wsStorage.onmessage = onStorageMessage_.bind(this);
    this.wsStorage.onclose = onStorageClose_.bind(this);
    this.wsStorage.onerror = onStorageError_.bind(this);
  }
  onReady() {
  }
  onStorage(data) {
  }
  
  get(path){
  }
  
  onStorageOpen_(evt) {
    console.log('onStorageOpen_:evt=<',evt,'>');
    let self = this;
    setTimeout(function(){
      self.onReady();
    },1);
  }
  onStorageMessage_(evt) {
    //console.log('onStorageMessage_:evt.data=<',evt.data,'>');
    let jsonMsg = JSON.parse(evt.data);
    //console.log('onStorageMessage_:jsonMsg=<',jsonMsg,'>');
    if(jsonMsg.result && jsonMsg.result.data) {
      this.onStorage(jsonMsg.result.data);
    }
  }
  onStorageClose_(evt) {
    console.log('onStorageClose_:evt=<',evt,'>');
  }
  onStorageError_(evt) {
    console.log('onStorageError_:evt=<',evt,'>');
  }

};

</script>
