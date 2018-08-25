<script type="text/javascript">

let notify = false;
function publishHotUpGofuro(keyChannel) {
  if(notify && notify.isReady) {
    notify.publish({hotup:true});
    return;
  }
  notify = new WatorNotify(keyChannel);
  notify.isReady = false;
  notify.onReady = () => {
    notify.publish({hotup:true});
    notify.isReady = true;
  };
  notify.subscribe( (msg) => {
    console.log('notify.subcribe:msg=<',msg,'>');
  });
  console.log('notify=<',notify,'>');
}


</script>
