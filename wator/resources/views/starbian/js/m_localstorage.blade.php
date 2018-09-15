<script type="text/javascript">

loadLocalStorage = () => {
  console.log('loadLocalStorage: WebViewLocalStorage=<',WebViewLocalStorage,'>');
  let keys = WebViewLocalStorage.keys();
  console.log('WebViewJS.loadLocalStorage: keys=<',keys,'>');
};

saveLocalStorage = () => {
  console.log('saveLocalStorage: WebViewLocalStorage=<',WebViewLocalStorage,'>');
};

</script>
