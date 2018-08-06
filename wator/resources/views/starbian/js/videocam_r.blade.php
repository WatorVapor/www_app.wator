<script type="text/javascript">


function onNotifyReady() {
  let params = location.pathname.split('/');
  let key = params[params.length -1];
  console.log('onNotifyReady:key=<',key,'>');
  if(key) {
    sendMsg(key,{start:true});
  }
}

</script>
