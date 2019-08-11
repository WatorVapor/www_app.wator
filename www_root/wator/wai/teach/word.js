const wss = 'wss://www.wator.xyz/wai/wss'
const sock = new WebSocket(wss);
sock.onopen = (e) => {
  console.log('onopen e=<',e,'>');
};
sock.onerror = (error) =>{
  console.error('onerror error=<',error,'>');
};
sock.onmessage = (e) => {
  console.log('onmessage e=<',e,'>');
};
