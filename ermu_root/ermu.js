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
  console.log('onMessageWSS:: event=<', event,'');
};
const onCloseWSS = (event)=> {
  console.log('onCloseWSS:: event=<', event,'');
};
const onErrorWSS = (event)=> {
  console.log('onErrorWSS:: event=<', event,'');
};

const onMessageWSS = (event)=> {
  console.log('onMessageWSS:: event.data=<', event.data,'');
};

const uiOnClickSearch = (evt) => {
  //console.log('onMessageWSS::uiOnClickSearch evt=<', evt,'');
  const text = evt.parentElement.parentElement.getElementsByTagName('input')[0].value.trim();
  //console.log('onMessageWSS::uiOnClickSearch text=<', text,'');
  if(text) {
    startSearchText(text);
  }
};

const LocalStorageHistory = 'wator/ermu/history';
const startSearchText = (words) => {
  localStorage.setItem(LocalStorageHistory,words);
  //console.log('onMessageWSS::startSearchText words=<', words,'');
  const msg = {words:words};
  if(socket) {
    socket.send(JSON.stringify(msg));
  }
};

const getHistory = () => {
  return localStorage.getItem(LocalStorageHistory);
};