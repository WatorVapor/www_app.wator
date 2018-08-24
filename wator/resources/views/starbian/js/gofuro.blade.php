<script type="text/javascript">

function publishHotUpGofuro(keyChannel) {
  let notify = new WatorNotify(keyChannel);
  notify.isReady = false;
  notify.onReady = () => {
    notify.publish({hotup:true});
    notify.isReady = true;
  };
  notify.subscribe( (msg) => {
    console.log('notify.subcribe:msg=<',msg,'>');
    if(msg && msg.start) {
      startWebRTC();
    }
    if(msg && msg.answer) {
      onRemoteAnswer(msg.answer);
    }
    if(msg && msg.ice) {
      onRemoteICE(msg.ice);
    }
  });
  console.log('notify=<',notify,'>');
}


</script>
