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
  const route = parseRoute();
  console.log('onOpenWSS:: route=<', route,'>');
  if(route === 'search') {
    const searchMsg = getHistory();
    console.log('onOpenWSS:: searchMsg=<', searchMsg,'>');
    if(searchMsg.words) {
      startSearchText(searchMsg);
    }
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
  let begin = parseInt(urlParams.get('begin'));
  //console.log('parseURLParam:: begin=<', begin,'>');
  let end = parseInt(urlParams.get('end'));
  //console.log('parseURLParam:: end=<', end,'>');
  return { words:words,begin:begin,end:end};
}

const parseRoute = () => {
  //console.log('parseRoute:: window.location.pathname=<', window.location.pathname,'>');
  if(window.location.pathname.endsWith('search.html')) {
    return 'search';
  }
  if(window.location.pathname.endsWith('/ermu/')) {
    return 'ermu';
  }
  return '';
}


const onMessageWSS = (event)=> {
  //console.log('onMessageWSS:: event.data=<', event.data,'>');
  try {
    const jMsg = JSON.parse(event.data);
    //console.log('onMessageWSS:: jMsg=<', jMsg,'>');
    if(jMsg.stats) {
      wsOnStatsResult(jMsg.stats);
    } else if (jMsg.results) {
      wsOnSearchResult(jMsg.results,jMsg.words);
    } else if (jMsg.summaryResult) {
      wsOnSearchSummaryResult(jMsg.summaryResult);
    } else {
      console.log('onMessageWSS:: jMsg=<', jMsg,'>');
    }
  } catch (e) {
    console.log('onMessageWSS:: e=<', e,'>');
  }
};


const wsOnStatsResult = (msg) => {
  console.log('wsOnStatsResult:: msg=<', msg,'>');
  try {
    onShowStatsResultApp(msg);
  } catch (e) {
    console.log('wsOnStatsResult:: e=<', e,'>');
  }
}

const gAllResultsByCID = {}

const wsOnSearchResult = async(msg,words) => {
  //console.log('wsOnSearchResult:: msg=<', msg,'>');
  for(const cid of msg) {
    if(!gAllResultsByCID[cid]){
      gAllResultsByCID[cid] = true
      //console.log('wsOnSearchResult:: cid=<', cid,'>');
      onShowSearchResultFrameRow(cid);
    }
  }
}

const gAllSummaryByCID = {}
const wsOnSearchSummaryResult = async(msg) => {
  //console.log('wsOnSearchSummaryResult:: msg=<', msg,'>');
  for(const cid in msg) {
    if(!gAllSummaryByCID[cid]){
      gAllSummaryByCID[cid] = true
      console.log('wsOnSearchSummaryResult:: cid=<', cid,'>');
      const searchSummary = msg[cid];
      console.log('wsOnSearchSummaryResult:: searchSummary=<', searchSummary,'>');
      onShowSearchResultOneRow(cid,searchSummary);
    }
  }
}

const LocalStorageHistory = 'wator/ermu/history';
const startSearchText = (searchMsg) => {
  localStorage.setItem(LocalStorageHistory,JSON.stringify(searchMsg));
  //console.log('onMessageWSS::startSearchText searchMsg=<', searchMsg,'>');
  if(socket) {
    socket.send(JSON.stringify(searchMsg));
  }
};

const getHistoryKeywords = () => {
  const historyStr = localStorage.getItem(LocalStorageHistory);
  try {
    const historyJson = JSON.parse(historyStr);
    //console.log('onMessageWSS::getHistoryKeywords historyJson=<', historyJson,'>');
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
    //console.log('onMessageWSS::getHistory historyJson=<', historyJson,'>');
    return historyJson;
  } catch(e) {
    console.log('onMessageWSS::getHistory e=<', e,'>');
  }
  return {};
};



