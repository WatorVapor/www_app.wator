<script type="text/javascript">

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
function buf2hex(buffer) { // buffer is an ArrayBuffer
  return Array.prototype.map.call(new Uint8Array(buffer), x => ('00' + x.toString(16)).slice(-2)).join('');
}
function getPubKey(key) {
  window.crypto.subtle.exportKey('raw',key)
  .then(function(keydata){
    //console.log('getPubKey keydata=<' , keydata , '>');
    WATOR.pubKeyHex = buf2hex(keydata);
    //console.log('getPubKey WATOR.pubKeyHex=<' , WATOR.pubKeyHex , '>');
    subscribe();
    if(typeof onUpdatePublicKey === 'function') {
      onUpdatePublicKey(WATOR.pubKeyHex);
    }
  })
  .catch(function(err){
    console.error(err);
  });
}


const KEY_REMOTE_NAME = 'starbian-ecdsa-remote-keys';
WATOR.addRemoteKey = function(pubKey) {
  console.log('WATOR.addRemoteKey pubKey=<' , pubKey , '>');
  let key = localStorage.getItem(KEY_REMOTE_NAME);
  let keyJson = JSON.parse(key);
  if(keyJson) {
    keyJson.push(pubKey);
    keyJson = keyJson.filter( onlyUnique );
  } else {
    keyJson = [pubKey];
  }
  let keyStr = JSON.stringify(keyJson);
  console.log('savePrivKey keyStr=<' , keyStr , '>');
  localStorage.setItem(KEY_REMOTE_NAME,keyStr);
};
function onlyUnique(value, index, self) { 
    return self.indexOf(value) === index;
}
WATOR.getRemoteKeys = function() {
  let key = localStorage.getItem(KEY_REMOTE_NAME);
  let keyJson = JSON.parse(key);
  return keyJson;
}
WATOR.connect = function(pubKey) {
  console.log('WATOR.connect pubKey=<' , pubKey , '>');
}
WATOR.removeKey = function(pubKey) {
  console.log('WATOR.removeKey pubKey=<' , pubKey , '>');
  let key = localStorage.getItem(KEY_REMOTE_NAME);
  let keyJson = JSON.parse(key);
  console.log('WATOR.removeKey keyJson=<' , keyJson , '>');
  let index = keyJson.indexOf(pubKey);
  console.log('WATOR.removeKey index=<' , index , '>');
  if(index) {
    let newKeys = keyJson.slice(index);
    console.log('WATOR.removeKey newKeys=<' , newKeys , '>');
    let keyStr = JSON.stringify(newKeys);
    console.log('savePrivKey keyStr=<' , keyStr , '>');
    localStorage.setItem(KEY_REMOTE_NAME,keyStr);
  }
}
</script>
