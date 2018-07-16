<script type="text/javascript">

let uri = "wss://www.wator.xyz/ws/starbian";
let ws = new WebSocket(uri);

ws.onopen = onNotifyOpen_;
ws.onmessage = onNotifyMessage_;
ws.onclose = onNotifyClose_;
ws.onerror = onNotifyError_;

function onNotifyOpen_(evt) {
  console.log('onNotifyOpen_:evt=<',evt,'>');
  console.log('onNotifyOpen_:WATOR.pubKey=<',WATOR.pubKey,'>');
}
function onNotifyMessage_(evt) {
  console.log('onNotifyMessage_:evt.data=<',evt.data,'>');
  let jsonMsg = JSON.parse(evt.data);
  console.log('onNotifyMessage_:jsonMsg=<',jsonMsg,'>');
  if(typeof onUpdateData === 'function' && jsonMsg) {
  }
}
function onNotifyClose_(evt) {
  console.log('onNotifyClose_:evt=<',evt,'>');
}
function onNotifyError_(evt) {
  console.log('onNotifyError_:evt=<',evt,'>');
}





$(document).ready(function(){
  setTimeout(function(){
    onInitCrypto();
  },0);
});

var WATOR = {};


const KEY_NAME = 'starbian-ecdsa-key';
function onInitCrypto() {
  let key = localStorage.getItem(KEY_NAME);
  //console.log('onInitCrypto:key=<',key,'>');
  if(key) {
    onLoadSavedKey(key);
  } else {
    onCreateKey();
  }
}

function onCreateKey (){
  window.crypto.subtle.generateKey(
    {
      name: 'ECDSA',
      namedCurve: 'P-256',
    },
    true,
    ['sign','verify']
  )
  .then(function(key){
    WATOR.pubKey = key.publicKey;
    getPubKey(key.publicKey);
    WATOR.prvKey = key.privateKey;
    savePrivKey(key.privateKey);
  })
  .catch(function(err){
    console.error(err);
  });
}

function savePrivKey(key) {
  window.crypto.subtle.exportKey('jwk',key)
  .then(function(keydata){
    console.log('savePrivKey keydata=<' , keydata , '>');
    let keyStr = JSON.stringify(keydata);
    console.log('savePrivKey keyStr=<' , keyStr , '>');
    localStorage.setItem(KEY_NAME,keyStr);
  })
  .catch(function(err){
    console.error(err);
  });
}


function onLoadSavedKey(privSave) {
  let key = JSON.parse(privSave);
  if(!key) {
    return;
  }
  window.crypto.subtle.importKey(
    'jwk',
    key,
    {
      name: 'ECDSA',
      namedCurve: 'P-256', 
    },
    true, 
    ['sign']
  )
  .then(function(privateKey){
    console.log('privateKey=<' , privateKey , '>');
    WATOR.prvKey = privateKey;
  })
  .catch(function(err){
    console.error(err);
  });
  //console.log('key=<',key ,'>');
  //let key
  delete key.d;
  key.key_ops[0] = 'verify';
  //console.log('key=<',key ,'>');

  window.crypto.subtle.importKey(
    'jwk',
    key,
    {
      name: 'ECDSA',
      namedCurve: 'P-256', 
    },
    true, 
    ['verify']
  )
  .then(function(publicKey){
    console.log('publicKey=<' , publicKey , '>');
    WATOR.pubKey = publicKey;
    getPubKey(publicKey);
  })
  .catch(function(err){
    console.error(err);
  });
}

function getPubKey(key) {
  window.crypto.subtle.exportKey('raw',key)
  .then(function(keydata){
    console.log('savePrivKey keydata=<' , keydata , '>');
  })
  .catch(function(err){
    console.error(err);
  });
}

</script>
