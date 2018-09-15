<script type="text/javascript">

loadLocalStorage = () => {
  console.log('loadLocalStorage: WebViewLocalStorage=<',WebViewLocalStorage,'>');
  let keys = WebViewLocalStorage.keys();
  console.log('WebViewJS.loadLocalStorage: keys=<',keys,'>');
};

document.addEventListener('DOMContentLoaded', () =>{
  setTimeout(saveLocalStorage,5000);
}, false);

saveLocalStorage = () => {
  console.log('saveLocalStorage: localStorage=<',localStorage,'>');
  let keys = Object.keys(localStorage);
  console.log('saveLocalStorage: keys=<',keys,'>');
  for (let key in localStorage){
    console.log('saveLocalStorage: key=<',key,'>');
    let value = localStorage.getItem(key);
    console.log('saveLocalStorage: value=<',value,'>');
    try {
      console.log('saveLocalStorage: WebViewLocalStorage=<',WebViewLocalStorage,'>');
      WebViewLocalStorage.setItem(key,value);
    }catch(e) {
      console.warn('saveLocalStorage: e=<',e,'>');
    }
  }
};

</script>
