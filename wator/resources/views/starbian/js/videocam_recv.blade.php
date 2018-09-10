<script type="text/javascript">

const params = location.pathname.split('/');
const keyChannel = params[params.length -1];
let rtc = new StarBianRtc(keyChannel);

rtc.subscribeMedia( (event) => {
  console.log('subscribeMedia event=<',event,'>');
  document.getElementById("video").srcObject = event.streams[0];
});


</script>
