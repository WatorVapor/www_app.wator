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
      $("#top-share-key-onetime-progress").removeClass("d-none");
      console.log('onSharedPubKey password=<' , password , '>');
    });
  } catch(e) {
    console.error(e);
  }
}
</script>
