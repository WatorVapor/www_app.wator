<script type="text/javascript">
try {    
  let uri = "ws://127.0.0.1:18080";
  let ws = new WebSocket(uri);
  ws.onopen =  (evt) => {
    console.log('evt=<' , evt , '>');
    setTimeOut(readAllSettings,0);
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
  ws.send(JSON.stringify({cmd:'readall'}));
}
</script>
