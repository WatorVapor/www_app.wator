<script type="text/javascript">

let starbian = new StarBian.BroadCast();
starbian.isReady = false;
starbian.onReady = () => {
  starbian.isReady = true;
};


function onSharedPubKey (elem) {
  try {
    console.log('onSharedPubKey  elem=<' , elem , '>');
    elem.setAttribute('disabled','true');
    starbian.broadcastPubKey( (status,password) => {
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
      $("#text-share-key-onetime-password").toggleClass('bg-success');
      
      
      $("#text-share-key-onetime-progress").text(status *10);
      $("#text-share-key-onetime-progress").attr('style','width: ' + status *10 + '%');
      $("#text-share-key-onetime-progress").attr('aria-valuenow',status *10);
      $("#top-share-key-onetime-progress").removeClass("d-none");
      console.log('onSharedPubKey password=<' , password , '>');
    });
  } catch(e) {
    console.error(e);
  }
}

function onSearchPubKey (elem) {
  try {
    console.log('onSearchPubKey  elem=<' , elem , '>');
    let root = elem.parentElement.parentElement;
    console.log('onSearchPubKey root=<' , root , '>');
    let textPassword = root.getElementsByTagName('input')[0].value;
    console.log('onSearchPubKey textPassword=<' , textPassword , '>');
    if(!textPassword) {
      return;
    }
    starbian.listenPubKey(textPassword.trim(), (pubKey) => {
      console.log('onSearchPubKey pubKey=<' , pubKey , '>');
      $("#text-remote-device-key").text(pubKey);
    });
  } catch(e) {
    console.error(e);
  }
}

</script>
