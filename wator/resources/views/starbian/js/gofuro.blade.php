<script type="text/javascript">

let starbian = false;
function publishHotUpGofuro(keyChannel) {
  if(starbian && starbian.isReady) {
    starbian.publish({hotup:true});
    return;
  }
  starbian = new StarBian.Peer(keyChannel);
  starbian.isReady = false;
  starbian.onReady = () => {
    starbian.publish({hotup:true});
    starbian.isReady = true;
  };
  starbian.subscribe( (msg) => {
    console.log('starbian.subcribe:msg=<',msg,'>');
  });
  console.log('starbian=<',starbian,'>');
}

</script>
