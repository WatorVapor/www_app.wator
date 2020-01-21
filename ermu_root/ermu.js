const iConstOnePageResult = 20;

//console.log(':: location=<', location,'');
const uri = 'wss://' + location.hostname + '/ermu/wss';
const socket = new WebSocket(uri);
socket.addEventListener('open', (event) => {
  setTimeout(() => {
    onOpenWSS(event)
  },1);
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
  //console.log('onOpenWSS:: event=<', event,'>');
  const searchMsg = getHistory();
  console.log('onOpenWSS:: searchMsg=<', searchMsg,'>');
  if(searchMsg.words) {
    startSearchText(searchMsg);
  }
};
const onCloseWSS = (event)=> {
  console.log('onCloseWSS:: event=<', event,'>');
};
const onErrorWSS = (event)=> {
  console.log('onErrorWSS:: event=<', event,'>');
};

const parseURLParam =() => {
  //console.log('parseURLParam:: window.location.search=<', window.location.search,'>');
  const urlParams = new URLSearchParams(window.location.search);
  //console.log('parseURLParam:: urlParams=<', urlParams,'>');
  let words = urlParams.get('words');
  //console.log('parseURLParam:: words=<', words,'>');
  let start = parseInt(urlParams.get('start'));
  //console.log('parseURLParam:: start=<', start,'>');
  let end = parseInt(urlParams.get('end'));
  //console.log('parseURLParam:: end=<', end,'>');
  return { words:words,start:start,end:end};
}

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
const startSearchText = (searchMsg) => {
  localStorage.setItem(LocalStorageHistory,JSON.stringify(searchMsg));
  //console.log('onMessageWSS::startSearchText searchMsg=<', searchMsg,'>');
  if(socket) {
    socket.send(JSON.stringify(searchMsg));
    allMessageRecievedOfOneSearch = {};
  }
};

const getHistoryKeywords = () => {
  const historyStr = localStorage.getItem(LocalStorageHistory);
  try {
    const historyJson = JSON.parse(historyStr);
    console.log('onMessageWSS::getHistoryKeywords historyJson=<', historyJson,'>');
    return historyJson.words;
  } catch(e) {
    console.log('onMessageWSS::getHistoryKeywords e=<', e,'>');
  }
  return null;
};

const getHistory = () => {
  const historyStr = localStorage.getItem(LocalStorageHistory);
  try {
    const historyJson = JSON.parse(historyStr);
    console.log('onMessageWSS::getHistory historyJson=<', historyJson,'>');
    return historyJson;
  } catch(e) {
    console.log('onMessageWSS::getHistory e=<', e,'>');
  }
  return {};
};



