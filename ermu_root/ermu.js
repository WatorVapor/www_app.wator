//console.log(':: location=<', location,'');
const uri = 'wss://' + location.hostname + '/ermu/wss';
const socket = new WebSocket(uri);
socket.addEventListener('open', (event) => {
  onOpenWSS(event);
});
socket.addEventListener('close', (event) => {
  onCloseWSS(event);
});
socket.addEventListener('error', (event) => {
  onErrorWSS(event);
});
socket.addEventListener('message', (event) => {
  onMessageWSS(event);
});


const onOpenWSS = (event)=> {
  console.log('onMessageWSS:: event=<', event,'>');
};
const onCloseWSS = (event)=> {
  console.log('onCloseWSS:: event=<', event,'>');
};
const onErrorWSS = (event)=> {
  console.log('onErrorWSS:: event=<', event,'>');
};

let allMessageRecievedOfOneSearch = {};

const onMessageWSS = (event)=> {
  //console.log('onMessageWSS:: event.data=<', event.data,'>');
  try {
    const jMsg = JSON.parse(event.data);
    //console.log('onMessageWSS:: jMsg=<', jMsg,'>');
    if(jMsg && jMsg.keyAddress && jMsg.address) {
      const indexKey = `${jMsg.keyAddress}-_- ${jMsg.address}`;
      if(allMessageRecievedOfOneSearch[indexKey]) {
        //console.log('onMessageWSS:: jMsg=<', jMsg,'>');
      } else {
        allMessageRecievedOfOneSearch[indexKey] = jMsg;
        wsOnNewSearchResult(jMsg);
      }
    } else {
      console.log('onMessageWSS:: jMsg=<', jMsg,'>');
    }
  } catch (e) {
    console.log('onMessageWSS:: e=<', e,'>');
  }
};

const uiOnClickSearch = (evt) => {
  //console.log('onMessageWSS::uiOnClickSearch evt=<', evt,'>');
  const text = evt.parentElement.parentElement.getElementsByTagName('input')[0].value.trim();
  //console.log('onMessageWSS::uiOnClickSearch text=<', text,'>');
  if(text) {
    startSearchText(text);
  }
};

const wsOnNewSearchResult = (msg) => {
  //console.log('wsOnNewSearchResult:: msg=<', msg,'>');
  try {
    const jMsg = JSON.parse(msg.data);
    if(jMsg) {
      console.log('wsOnNewSearchResult:: jMsg=<', jMsg,'>');
      console.log('wsOnNewSearchResult:: typeof jMsg=<', typeof(jMsg),'>');
      const jMsg2 = JSON.parse(jMsg);
      console.log('wsOnNewSearchResult:: jMsg2=<', jMsg2,'>');
      onShowTopResultApp(jMsg2);
    } else {
      //console.log('wsOnNewSearchResult:: msg.data=<', msg.data,'>');
    }
  } catch (e) {
    console.log('wsOnNewSearchResult:: e=<', e,'>');
  }
}

const LocalStorageHistory = 'wator/ermu/history';
const startSearchText = (words) => {
  localStorage.setItem(LocalStorageHistory,words);
  //console.log('onMessageWSS::startSearchText words=<', words,'>');
  const msg = {words:words};
  if(socket) {
    socket.send(JSON.stringify(msg));
    allMessageRecievedOfOneSearch = {};
  }
};

const getHistory = () => {
  return localStorage.getItem(LocalStorageHistory);
};