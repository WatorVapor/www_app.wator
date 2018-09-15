<script type="text/javascript">

loadLocalStorage = () => {
  console.log('loadLocalStorage: WebViewLocalStorage=<',WebViewLocalStorage,'>');
  let keys = WebViewLocalStorage.keys();
  console.log('WebViewJS.loadLocalStorage: keys=<',keys,'>');
};

saveLocalStorage = () => {
  console.log('saveLocalStorage: WebViewLocalStorage=<',WebViewLocalStorage,'>');
  let keys = Object.keys(localStorage);
  for (let key in keys){
   console.log('saveLocalStorage: key=<',key,'>');
   let value = localStorage.getItem(key);
   console.log('saveLocalStorage: value=<',value,'>');
   WebViewLocalStorage.setItem(key,value);
  }
};

</script>
