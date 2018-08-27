<script type="text/javascript">

let starbian = false;
function publishHotUpGofuro(keyChannel) {
  if(starbian && starbian.isReady) {
    starbian.publish({hotup:true});
    return;
  }
  starbian = new StarBian(keyChannel);
  starbian.isReady = false;
  starbian.onReady = () => {
    starbian.publish({hotup:true});
    starbian.isReady = true;
  };
  starbian.subscribe( (msg) => {
    console.log('starbian.subcribe:msg=<',msg,'>');
  });
  console.log('starbian=<',notify,'>');
}


</script>
