<script type="text/javascript">
function onImportKey(elem) {
  console.log('onImportKey:elem=<',elem,'>');
  let elemKey = document.getElementById("import-key-value");
  console.log('onImportKey:elemKey=<',elemKey,'>');
  let keyStr = elemKey.value;
  console.log('onImportKey:keyStr=<',keyStr,'>');
  let keys = keyStr.split('-----END PRIVATE KEY-----');
  console.log('onImportKey:keys=<',keys,'>');
  let rsaKey = KEYUTIL.getKeyFromPlainPrivatePKCS8PEM(keyStr);
  console.log('rsaKey=<',rsaKey,'>');

}
</script>

