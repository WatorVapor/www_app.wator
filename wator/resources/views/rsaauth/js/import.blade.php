<script type="text/javascript">
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
  let pubKey = KEYUTIL.getKey(keys.prv);
  console.log('pubKey=<',pubKey,'>');
  let msg = 'wator';
  let sign = prvKey.sign(msg);
  console.log('sign=<',sign,'>');
  let verified = pubKey.verify(msg,sign);
  console.log('verified=<',verified,'>');
  if(verified) {
  } else {
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
</script>

