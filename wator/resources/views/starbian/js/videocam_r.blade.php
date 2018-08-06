<script type="text/javascript">


let keyChannel = false;

function onNotifyReady() {
  let params = location.pathname.split('/');
  let key = params[params.length -1];
  console.log('onNotifyReady:key=<',key,'>');
  if(key) {
    keyChannel = key;
    sendMsg(key,{start:true});
    startCamera();
  }
  
}

function startCamera() {
  console.log('startCamera:keyChannel=<',keyChannel,'>');
}

</script>
