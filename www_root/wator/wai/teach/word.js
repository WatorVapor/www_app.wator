
const wss = 'wss://www.wator.xyz/wai/wss'
const sock = new WebSocket(wss);
sock.onopen = (e) => {
  console.log('onopen e=<',e,'>');
  requestWords(sock);
};
sock.onerror = (error) =>{
  console.error('onerror error=<',error,'>');
};
sock.onmessage = (e) => {
  console.log('onmessage e=<',e,'>');
  try {
    const msgJson = JSON.parse(e.data);
    //console.log('onmessage msgJson=<',msgJson,'>');
    if(msgJson.teach && msgJson.teach === 'word' && msgJson.stage && msgJson.stage === 'yesno') {
      onTeachWordYesNo(msgJson.words);
    }
  } catch(error) {
    console.error('onmessage error=<',error,'>');
  }
};

const gKeyId = SecAuth.getKeyID();
const requestWords = (sock) => {
  const msg = {
    id:gKeyId,
    teach:'word',
    stage:'yesno'
  };
  sock.send(JSON.stringify(msg));  
}

const onTeachWordYesNo = (words) => {
  //console.log('onTeachWordYesNo words=<',words,'>');
  if(typeof onUITeachWordsYesNo === 'function') {
    onUITeachWordsYesNo(words);
  }
}