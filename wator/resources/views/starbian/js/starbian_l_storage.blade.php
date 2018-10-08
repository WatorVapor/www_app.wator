<script type="text/javascript">
let gWS = false;
let gLinuxTTS = false;
try {    
  let uri = "ws://127.0.0.1:18080";
  let ws = new WebSocket(uri);
  ws.onopen =  (evt) => {
    console.log('evt=<' , evt , '>');
    gWS = ws;
    gLinuxTTS = new DoLinuxTTS();
    setTimeout(readAllSettings,0);
    setTimeout(setMyKey,0);
  };
  ws.onmessage = (evt) => {
    console.log('evt=<' , evt , '>');
    let jsonMsg = JSON.parse(evt.data);
    if(jsonMsg) {
      onSettingRead(jsonMsg);
    }
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
  gWS.send(JSON.stringify({cmd:'readall'}));
}

onSettingRead = (jsonMsg) => {
  console.log('onSettingRead:jsonMsg=<',jsonMsg,'>');
  for(let i = 0;i < jsonMsg.length ;i++) {
    let storage = jsonMsg[i];
    console.log('onSettingRead:storage=<',storage,'>');
    let key = storage.key;
    console.log('onSettingRead:key=<',key,'>');
    let value = JSON.stringify(storage.value);
    console.log('onSettingRead:value=<',value,'>');
    localStorage.setItem(key,value);
  }
}

setMyKey = () => {
  if(myKey) {
    gWS.send(JSON.stringify({cmd:'set',myKey:myKey}));
  }
}


let myKey = false;
StarBian.onReadyOfKey = (key) => {
  console.log('StarBian.onReadyOfKey key=<' , key , '>');
  myKey = key;
  if(gWS) {
    gWS.send(JSON.stringify({cmd:'set',myKey:myKey}));
  }
};

class DoLinuxTTS {
    constructor() {
    }
    say(text,volume) {
        gWS.send(JSON.stringify({cmd:'tts',text:text,volume:volume}));
    }
};

</script>
