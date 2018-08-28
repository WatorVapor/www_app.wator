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
    elem.setAttribute('disabled','true');
    starbian.sharePubKey( (status,password) => {
      console.log('onSharedPubKey status=<' , status , '>');
      console.log('onSharedPubKey password=<' , password , '>');
    });
  } catch(e) {
    console.error(e);
  }
}
</script>
