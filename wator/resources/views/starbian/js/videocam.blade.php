<script type="text/javascript">

let starbian = new StarBian();
starbian.isReady = false;
starbian.onReady = () => {
  starbian.isReady = true;
};
starbian.subscribe( (msg) => {
  console.log('starbian.subcribe:msg=<',msg,'>');
});

function onSharedPubKey (elem) {
  try {
    console.log('onSharedPubKey  elem=<' , elem , '>');
    let root = elem.parentElement;
    console.log('onSharedPubKey root=<' , root , '>');
  } catch(e) {
    console.error(e);
  }
}
</script>
