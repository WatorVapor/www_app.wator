const uri = 'wss://www.wator.xyz/ermu/wss';
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
