//console.log(':: location=<', location,'');
const uri = 'wss://' + location.hostname + '/ermu/wss';
const socket = new WebSocket(uri);
socket.addEventListener('open', (event) => {
  onOpenWSS(event);
});

socket.addEventListener('message', (event) => {
  onMessageWSS(event);
});

const onOpenWSS = (event)=> {
  console.log('onMessageWSS:: event=<', event,'');
};

const onMessageWSS = (event)=> {
  console.log('onMessageWSS:: event.data=<', event.data,'');
};

uiOnClickSearch = (evt) => {
  console.log('onMessageWSS::uiOnClickSearch evt=<', evt,'');
  const text = evt.parentElement.parentElement.getElementsByTagName('input')[0].value.trim();
  console.log('onMessageWSS::uiOnClickSearch text=<', text,'');
};
