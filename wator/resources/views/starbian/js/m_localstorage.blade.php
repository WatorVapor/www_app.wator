<script type="text/javascript">
var WebViewJS = {};
WebViewJS.loadLocalStorage = () => {
  console.log('WebViewJS.loadLocalStorage: WebViewLocalStorage=<',WebViewLocalStorage,'>');
  let keys = WebViewLocalStorage.keys();
  console.log('WebViewJS.loadLocalStorage: keys=<',keys,'>');
};

WebViewJS.saveLocalStorage = () => {
  console.log('WebViewJS.saveLocalStorage: WebViewLocalStorage=<',WebViewLocalStorage,'>');
};

</script>
