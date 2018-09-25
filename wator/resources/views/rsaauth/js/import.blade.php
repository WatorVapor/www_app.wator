<script type="text/javascript">
let keyImportPub = false;
let keyImportPrv = false;


function onImportKey(elem) {
  console.log('onImportKey:elem=<',elem,'>');
  let elemKey = document.getElementById("import-key-value");
  console.log('onImportKey:elemKey=<',elemKey,'>');
  let keyStr = elemKey.value;
  console.log('onImportKey:keyStr=<',keyStr,'>');
  let keys = getKeys(keyStr)
  console.log('onImportKey:keys=<',keys,'>');
  let prvKey = KEYUTIL.getKey(keys.prv);
  console.log('prvKey=<',prvKey,'>');
  let pubKey = KEYUTIL.getKey(keys.pub);
  console.log('pubKey=<',pubKey,'>');
  let msg = 'wator';
  let sign = prvKey.sign(msg,'sha1');
  console.log('sign=<',sign,'>');
  let verified = pubKey.verify(msg,sign);
  console.log('verified=<',verified,'>');
  if(verified) {
    keyImportPub = pubKey;
    keyImportPrv = prvKey;
    markAsGoodKeyPair();
  } else {
    keyImportPub = false;
    keyImportPrv = false;
    markAsBadKeyPair();
  }
}

function getKeys( keyStr) {
  let startPrv = keyStr.indexOf('-----BEGIN PRIVATE KEY-----')
  console.log('getKeys:startPrv=<',startPrv,'>');
  let endPrv = keyStr.indexOf('-----END PRIVATE KEY-----')
  console.log('getKeys:endPrv=<',endPrv,'>');
  let prvKey = keyStr.substr(startPrv,endPrv-startPrv) + '-----END PRIVATE KEY-----'
  console.log('getKeys:prvKey=<',prvKey,'>');

  let startPub = keyStr.indexOf('-----BEGIN PUBLIC KEY-----')
  console.log('getKeys:startPub=<',startPub,'>');
  let endPub = keyStr.indexOf('-----END PUBLIC KEY-----')
  console.log('getKeys:endPub=<',endPub,'>');
  let pubKey = keyStr.substr(startPub,endPub-startPub) + '-----END PUBLIC KEY-----'
  console.log('getKeys:pubKey=<',pubKey,'>');
  return {pub:pubKey,prv:prvKey};
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
    let pemPriv = KEYUTIL.getPEM(keyImportPrv,"PKCS8PRV");
    localStorage.setItem('auth.rsa.key.private',pemPriv);
  }
  if(keyImportPub && keyImportPrv) {
    let pemPub = KEYUTIL.getPEM(keyImportPub);
    localStorage.setItem('auth.rsa.key.public',pemPub);
    let token = KJUR.crypto.Util.sha512(pemPub);
    localStorage.setItem('auth.rsa.token',token);
    RSAAuth.upPubKey(function(status){
      console.log('onSaveKey:status=<',status,'>');
      if(status.status === 'success') {
        $( '#import-key-success').removeClass('d-none');
      } else {
        $( '#import-key-failure').removeClass('d-none');
      }
    });
  }
}

</script>

