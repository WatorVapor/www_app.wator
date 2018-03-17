<script type="text/javascript">
function onImportKey(elem) {
  console.log('onImportKey:elem=<',elem,'>');
  let elemKey = document.getElementById("import-key-value");
  console.log('onImportKey:elemKey=<',elemKey,'>');
  let keyStr = elemKey.value;
  console.log('onImportKey:keyStr=<',keyStr,'>');
  let keys = getKeys(keyStr)
  console.log('onImportKey:keys=<',keys,'>');
  let rsaKey = KEYUTIL.getKeyFromPlainPrivatePKCS8PEM(keyStr);
  console.log('rsaKey=<',rsaKey,'>');

}
function getKeys( keyStr) {
  let startPrv = keyStr.indexOf('-----BEGIN PRIVATE KEY-----')
  console.log('getKeys:startPrv=<',startPrv,'>');
  let endPrv = keyStr.indexOf('-----END PRIVATE KEY-----')
  console.log('getKeys:endPrv=<',endPrv,'>');
}
</script>

