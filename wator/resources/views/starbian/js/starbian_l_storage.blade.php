<script type="text/javascript">
let gWS = false;
try {    
  let uri = "ws://127.0.0.1:18080";
  let ws = new WebSocket(uri);
  ws.onopen =  (evt) => {
    console.log('evt=<' , evt , '>');
    gWS = ws;
    setTimeout(readAllSettings,0);
  };
  ws.onmessage = (evt) => {
    console.log('evt=<' , evt , '>');
  };
  ws.onclose = (evt) => {
    console.log('evt=<' , evt , '>');
  };
  ws.onerror = (evt) => { 
    console.log('evt=<' , evt , '>');
  };
} catch (e) {
  console.error('e=<' , e , '>');
}
readAllSettings = () => {
  if(gWS) {
    gWS.send(JSON.stringify({cmd:'readall'}));
  }
}

StarBian.onReadyOfKey = (key) => {
  console.log('StarBian.onReadyOfKey key=<' , key , '>');
};

</script>
