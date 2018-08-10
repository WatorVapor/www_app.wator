<script type="text/javascript">

$(document).ready(function(){
  setTimeout(function(){
    onInitCrypto();
  },0);
});
var WATOR = {};
const KEY_NAME = 'starbian-ecdsa-key';
const KEY_REMOTE_NAME = 'starbian-ecdsa-remote-keys';
function onInitCrypto() {
  let key = localStorage.getItem(KEY_NAME);
  //console.log('onInitCrypto:key=<',key,'>');
  if(key) {
    onLoadSavedKey(key);
  } else {
    onCreateKey();
  }  
  let keyRemote = localStorage.getItem(KEY_REMOTE_NAME);
  if(!keyRemote) {
    let keyStr = JSON.stringify([]);
    //console.log('addRemoteKey keyStr=<' , keyStr , '>');
    localStorage.setItem(KEY_REMOTE_NAME,keyStr);
  }
  createECDHKey();
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
    if(typeof onUpdatePublicKey === 'function') {
      onUpdatePublicKey(WATOR.pubKeyHex);
    }
  })
  .catch(function(err){
    console.error(err);
  });
}


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
  console.log('addRemoteKey keyStr=<' , keyStr , '>');
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
  let newKeys = keyJson.filter(key => pubKey !== key);
  console.log('WATOR.removeKey newKeys=<' , newKeys , '>');
  let keyStr = JSON.stringify(newKeys);
  console.log('WATOR.removeKey keyStr=<' , keyStr , '>');
  localStorage.setItem(KEY_REMOTE_NAME,keyStr);
}


function createECDHKey () {
  window.crypto.subtle.generateKey(
    {
      name: 'ECDH',
      namedCurve: 'P-256',
    },
    false,
    ['deriveKey','deriveBits']
  )
  .then(function(key){
    WATOR.ECDHKey = key;
    exportECDHPubKey(key.publicKey);
  })
  .catch(function(err){
    console.error(err);
  });
}
function exportECDHPubKey(pubKey) {
  crypto.subtle.exportKey('jwk', pubKey)
  .then(function(keydata){
    console.log('exportECDHPubKey keydata=<' , keydata , '>');
    WATOR.ECDHKeyPubJwk = keydata;
  })
  .catch(function(err){
    console.error(err);
  });
}

async function sha256(str) {
  const buf = await crypto.subtle.digest("SHA-256", new TextEncoder("utf-8").encode(str));
  console.log('WATOR.sign buf=<' , buf , '>');
  return Array.prototype.map.call(new Uint8Array(buf), x=>(('00'+x.toString(16)).slice(-2))).join('');
}


WATOR.sign = async function(msg) {
  console.log('WATOR.sign msg=<' , msg , '>');
  let hash = await sha256(msg);
  console.log('WATOR.sign hash=<' , hash , '>');
  let signatureStr = await crypto.subtle.sign('ECDSA', WATOR.prvKey, new TextEncoder("utf-8").encode(hash));
  console.log('WATOR.sign signatureStr=<' , signatureStr , '>');
  let signature = {
    pubKey:WATOR.pubKeyHex,
    hash:hash,
    sign:signatureStr
  };
  return signature;
}


</script>
