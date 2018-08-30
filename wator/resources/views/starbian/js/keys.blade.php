<script type="text/javascript">

$(document).ready(function(){
  setTimeout(function(){
    onInitCrypto();
  },0);
});
var WATOR = {};
const KEY_NAME = 'starbian-ecdsa-key';
const KEY_REMOTE_NAME = 'starbian-ecdsa-remote-keys';
const b58 = new base58();
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
    //getPrvKey(privateKey);
  })
  .catch(function(err){
    console.error(err);
  });
  WATOR.rsPrvKey = KEYUTIL.getKey(key);
  console.log('WATOR.rsPrvKey=<',WATOR.rsPrvKey ,'>');
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
  WATOR.rsPubKey = KEYUTIL.getKey(key);
  console.log('WATOR.rsPubKey=<',WATOR.rsPubKey ,'>');
  WATOR.pubKeyJWK = JSON.parse(JSON.stringify(key));
}
function buf2hex(buffer) { // buffer is an ArrayBuffer
  return Array.prototype.map.call(new Uint8Array(buffer), x => ('00' + x.toString(16)).slice(-2)).join('');
}
function getPubKey(key) {
  window.crypto.subtle.exportKey('raw',key)
  .then(function(keydata){
    console.log('getPubKey keydata=<' , keydata , '>');
    WATOR.pubKeyHex = buf2hex(keydata);
    //console.log('getPubKey WATOR.pubKeyHex=<' , WATOR.pubKeyHex , '>');
    WATOR.pubKeyB58 = b58.encode(new Uint8Array(keydata));
    console.log('getPubKey WATOR.pubKeyB58=<' , WATOR.pubKeyB58 , '>');
    if(typeof onUpdatePublicKey === 'function') {
      onUpdatePublicKey(WATOR.pubKeyB58);
    }
  })
  .catch(function(err){
    console.error(err);
  });
}

function getPrvKey(key) {
  window.crypto.subtle.exportKey('raw',key)
  .then(function(keydata){
    //console.log('getPrvKey keydata=<' , keydata , '>');
    WATOR.prvKeyHex = buf2hex(keydata);
    //console.log('getPrvKey WATOR.prvKeyHex=<' , WATOR.prvKeyHex , '>');
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
  if(keyJson) {
    return keyJson;
  } else {
    return [];
  }
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


/*
WATOR.sign = function(msg,cb) {
  console.log('WATOR.sign msg=<' , msg , '>');
  crypto.subtle.digest("SHA-256", new TextEncoder("utf-8").encode(msg))
  .then(function(buf) {
    let hash = Array.prototype.map.call(new Uint8Array(buf), x=>(('00'+x.toString(16)).slice(-2))).join('');
    console.log('WATOR.sign hash=<' , hash , '>');
    let alg = {
      name: "ECDSA",
      hash: {name: "SHA-256"}
    };
    crypto.subtle.sign(alg, WATOR.prvKey, new TextEncoder("utf-8").encode(hash))
    .then(function(signatureBuf) {
      console.log('WATOR.sign signatureBuf=<' , signatureBuf , '>');
      let signatureHex = Array.prototype.map.call(new Uint8Array(signatureBuf), x=>(('00'+x.toString(16)).slice(-2))).join('');
      let signature = {
        pubKey:WATOR.pubKeyJWK,
        pubKeyHex:WATOR.pubKeyHex,
        hash:hash,
        enc:'hex',
        sign:signatureHex
      };
      cb(signature);
    })
    .catch(function(err){
      console.error(err);
    });
  })
  .catch(function(err){
    console.error(err);
  });
};
*/

WATOR.sign = function(msg,cb) {
  //console.log('WATOR.sign msg=<' , msg , '>');
  crypto.subtle.digest("SHA-256", new TextEncoder("utf-8").encode(msg))
  .then(function(buf) {
    let hash = Array.prototype.map.call(new Uint8Array(buf), x=>(('00'+x.toString(16)).slice(-2))).join('');
    //console.log('WATOR.sign hash=<' , hash , '>');
    let ecSign = new KJUR.crypto.ECDSA({'curve': 'secp256r1'});
    //console.log('WATOR.sign ecSign=<' , ecSign , '>');
    //console.log('WATOR.sign WATOR.prvKeyHex=<' , WATOR.prvKeyHex , '>');
    
    let signEngine = new KJUR.crypto.Signature({alg: 'SHA256withECDSA'});
    signEngine.init({d: WATOR.rsPrvKey.prvKeyHex, curve: 'secp256r1'});
    signEngine.updateString(hash);
    let signatureHex = signEngine.sign();
    
    //let signatureHex = WATOR.rsPrvKey.signHex(hash);
    //let signatureHex = ecSign.signHex(hash,WATOR.prvKeyHex);
    //console.log('WATOR.sign signatureHex=<' , signatureHex , '>');
    let signature = {
      pubKey:WATOR.pubKeyJWK,
      pubKeyHex:WATOR.pubKeyHex,
      hash:hash,
      enc:'hex',
      sign:signatureHex
    };
    cb(signature);
  })
  .catch(function(err){
    console.error(err);
  });
};

function hex2buf(hex) {
  let buffer = new ArrayBuffer(hex.length / 2);
  let array = new Uint8Array(buffer);
  let k = 0;
  for (let i = 0; i < hex.length; i +=2 ) {
    array[k] = parseInt(hex[i] + hex[i+1], 16);
    k++;
  }
  return buffer;
}

function buf2hex(buf) {
  return Array.prototype.map.call(new Uint8Array(buf), x=>(('00'+x.toString(16)).slice(-2))).join('');
}


/*
WATOR.verify = function(content,key,msg,sign,cb) {
  let keyBuff = hex2buf(key);
  console.log('WATOR.verify keyBuff=<' , keyBuff , '>');
  let msgBuff = new TextEncoder("utf-8").encode(msg)
  console.log('WATOR.verify msgBuff=<' , msgBuff , '>');
  let signBuff = hex2buf(sign);
  console.log('WATOR.verify signBuff=<' , signBuff , '>');
  window.crypto.subtle.importKey(
    'jwk',
    keyBuff,
    {
      name: 'ECDSA',
      namedCurve: 'P-256', 
    },
    true, 
    ['verify']
  )
  .then(function(publicKey){
    console.log('WATOR.verify publicKey=<' , publicKey , '>');
    let alg = {
      name: "ECDSA",
      hash: {name: "SHA-256"}
    };
    window.crypto.subtle.verify(alg,publicKey,signBuff,msgBuff)
    .then(function(result){
      console.log('WATOR.verify result=<' , result , '>');
      
      cb(result);
    })
    .catch(function(err){
      console.error(err);
    });
  })
  .catch(function(err){
    console.error(err);
  });

};
*/


WATOR.verify = function(content,key,msg,sign,cb) {
  //console.log('WATOR.verify JSON.stringify(content)=<' , JSON.stringify(content) ,'>');
  crypto.subtle.digest("SHA-256", new TextEncoder("utf-8").encode(JSON.stringify(content)))
  .then(function(buf){
    let hashCal = Array.prototype.map.call(new Uint8Array(buf), x=>(('00'+x.toString(16)).slice(-2))).join('');
    //console.log('WATOR.verify hashCal=<' , hashCal , '>');
    //console.log('WATOR.verify msg=<' , msg , '>');
    if(hashCal !== msg) {
      cb(false);
    } else {
      let keyBuff = hex2buf(key);
      //console.log('WATOR.verify keyBuff=<' , keyBuff , '>');
      let msgBuff = new TextEncoder("utf-8").encode(msg)
      //console.log('WATOR.verify msgBuff=<' , msgBuff , '>');
      let signBuff = hex2buf(sign);
      //console.log('WATOR.verify signBuff=<' , signBuff , '>');

      let pubKey = KEYUTIL.getKey(key);
      //console.log('WATOR.verify pubKey=<' , pubKey , '>');

      let signEngine = new KJUR.crypto.Signature({alg: 'SHA256withECDSA'});
      signEngine.init({xy: pubKey.pubKeyHex, curve: 'secp256r1'});
      signEngine.updateString(msg);
      let result = signEngine.verify(sign);
      cb(result);
    }
  })
  .catch(function(err){
    console.error(err);
  });
};


WATOR.exchangeKey = function(pubKey,cb) {
  console.log('WATOR.exchangeKey pubKey=<' , pubKey , '>');
  crypto.subtle.importKey(
    'jwk',
    pubKey,
    { name: 'ECDH', namedCurve: 'P-256'},
    false,
    []
  ).then(key => {
    onExchangeKey(key,cb);
  })
  .catch(function(err){
    console.error(err);
  });
};

function onExchangeKey(remotePubKey,cb) {
  console.log('onExchangeKey remotePubKey=<' , remotePubKey , '>');
  crypto.subtle.deriveKey( 
    { name: 'ECDH', namedCurve: 'P-256', public: remotePubKey },
    WATOR.ECDHKey.privateKey,
    { name: 'AES-GCM', length: 128 },
    false,
    ['encrypt', 'decrypt']
  ).then(keyAES => {
    console.log('onExchangeKey keyAES=<' , keyAES , '>');
    WATOR.AESKey = keyAES;
    cb(keyAES);
  })
  .catch(function(err){
    console.error(err);
  });
}

WATOR.encrypt = function(msg,cb) {
  //console.log('WATOR.encrypt msg=<' , msg , '>');
  let iv = window.crypto.getRandomValues(new Uint8Array(12));
  const alg = { 
    name: 'AES-GCM',
    iv: iv
  };
  const ptUint8 = new TextEncoder().encode(JSON.stringify(msg));
  crypto.subtle.encrypt( 
    alg,
    WATOR.AESKey,
    ptUint8
  ).then(enMsg => {
    //console.log('WATOR.encrypt enMsg=<' , enMsg , '>');
    let enObj = {
      iv:buf2hex(iv),
      encrypt:buf2hex(enMsg)
    };
    cb(enObj);
  })
  .catch(function(err){
    console.error(err);
  });
}

WATOR.decrypt = function(msg,cb) {
  console.log('WATOR.decrypt msg=<' , msg , '>');
  if(!WATOR.AESKey) {
    cb({});
    return;
  }
  const alg = { 
    name: 'AES-GCM',
    iv: hex2buf(msg.iv)
  };
  const ptUint8 = hex2buf(msg.encrypt);
  //console.log('WATOR.decrypt WATOR.AESKey=<' , WATOR.AESKey , '>');
  crypto.subtle.decrypt( 
    alg,
    WATOR.AESKey,
    ptUint8
  ).then(plainBuff => {
    console.log('WATOR.decrypt plainBuff=<' , plainBuff , '>');
    let plainText = new TextDecoder().decode(plainBuff);
    console.log('WATOR.decrypt plainText=<' , plainText , '>');
    let plainJson = JSON.parse(plainText);
    console.log('WATOR.decrypt plainJson=<' , plainJson , '>');
    cb(plainJson);
  })
  .catch(function(err){
    console.error(err);
  });
}


</script>
