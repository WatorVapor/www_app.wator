let keyImportPub = false;
let keyImportPrv = false;

function onImportKey(elem) {
  console.log('onImportKey:elem=<',elem,'>');
  let elemKey = document.getElementById("import-key-value");
  console.log('onImportKey:elemKey=<',elemKey,'>');
  let keyStr = elemKey.value;
  console.log('onImportKey:keyStr=<',keyStr,'>');
  try {
    let keyJson = JSON.parse(keyStr)
    console.log('onImportKey:keyJson=<',keyJson,'>');
    let prvKey = KEYUTIL.getKey(keyJson);
    console.log('prvKey=<',prvKey,'>');

    let keyPubJson = JSON.parse(keyStr);
    delete keyPubJson.d;
    let pubKey = KEYUTIL.getKey(keyPubJson);
    console.log('pubKey=<',pubKey,'>');
    if(prvKey && pubKey) {
      keyImportPub = pubKey;
      keyImportPrv = prvKey;

      const pubHex = keyImportPub.pubKeyHex;
      console.log('SecAuth.createKeyPair_:: pubHex=<',pubHex,'>');
      const pubBuff = fromHexString(pubHex);
      console.log('SecAuth.createKeyPair_:: pubBuff=<',pubBuff,'>');
      const pubB58 = Base58.encode(pubBuff);
      console.log('SecAuth.createKeyPair_:: pubB58=<',pubB58,'>');     
      let elemToken = document.getElementById("sec.signup.accessToken");
      console.log('elemToken=<',elemToken,'>');
      if(elemToken) {
        elemToken.value = pubB58;
        console.log('elemToken.value=<',elemToken.value,'>');
      }
      
      markAsGoodKeyPair();
    }
  } catch(e) {
    keyImportPub = false;
    keyImportPrv = false;
    markAsBadKeyPair();    
  }
}



function markAsGoodKeyPair() {
  $( '#import-key-verify').addClass('d-none');
  $( '#import-key-discard').addClass('d-none');
  $( '#import-key-save').removeClass('d-none');
}
function markAsBadKeyPair() {
  $( '#import-key-verify').addClass('d-none');
  $( '#import-key-save').addClass('d-none');
  $( '#import-key-discard').removeClass('d-none');
}

function onSaveKey(elem) {
  console.log('onSaveKey:elem=<',elem,'>');
  if(keyImportPub && keyImportPrv){
    let jwkPrv = KEYUTIL.getJWKFromKey(keyImportPrv);
    console.log('onSaveKey:jwkPrv=<',jwkPrv,'>');
    localStorage.setItem(SecAuth.LS_AUTH_KEY_PRV,JSON.stringify(jwkPrv,undefined,2));

    let jwkPub = KEYUTIL.getJWKFromKey(keyImportPub);
    console.log('onSaveKey:jwkPub=<',jwkPub,'>');
    localStorage.setItem(SecAuth.LS_AUTH_KEY_PUB,JSON.stringify(jwkPub,undefined,2));
    
    const pubHex = keyImportPub.pubKeyHex;
    console.log('SecAuth.createKeyPair_:: pubHex=<',pubHex,'>');
    const pubBuff = fromHexString(pubHex);
    console.log('SecAuth.createKeyPair_:: pubBuff=<',pubBuff,'>');
    const pubB58 = Base58.encode(pubBuff);
    console.log('SecAuth.createKeyPair_:: pubB58=<',pubB58,'>');
    localStorage.setItem(SecAuth.LS_AUTH_KEY_TOKEN,pubB58);
    doUploadToken();
  }
}

function doUploadToken() {
  document.forms['secauth_upload_form'].submit();
}


const fromHexString = hexString =>
  new Uint8Array(hexString.match(/.{1,2}/g).map(byte => parseInt(byte, 16)));

const toHexString = bytes =>
  bytes.reduce((str, byte) => str + byte.toString(16).padStart(2, '0'), '');
