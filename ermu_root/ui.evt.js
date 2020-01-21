document.addEventListener('DOMContentLoaded',(evt) =>{
  onDocumentReadyUI(evt);
});


const onDocumentReadyUI = (evt) =>{
  console.log('ui.evt::onDocumentReadyUI evt=<', evt,'>');
  onShowSearchLastHistory();
};


const onShowSearchLastHistory = ()=> {
  let historyText = getHistoryKeywords();
  if(!historyText) {
    historyText = '搜索';
  }
  const keywordsElement = document.getElementById('search-keywords-input-text');
  keywordsElement.value = historyText;

};


const LocalStorageSearchKeyWordFromIndex = 'wator/ermu/search/keyword4index';
const uiOnClickSearchIndex = (evt) => {
  //console.log('onMessageWSS::uiOnClickSearchIndex evt=<', evt,'>');
  //console.log('onMessageWSS::uiOnClickSearchIndex location.href=<', location.href,'>');
  const text = evt.parentElement.parentElement.getElementsByTagName('input')[0].value.trim();
  if(text) {
    const searchHref = location.href + 'search.html?words=' + text + '&start=0&end=' + iConstOnePageResult;
    console.log('onMessageWSS::uiOnClickSearchIndex searchHref=<', searchHref,'>');
    localStorage.setItem(LocalStorageSearchKeyWordFromIndex,text);
    const searchMsg = { words:text,start:0,end:iConstOnePageResult};
    localStorage.setItem(LocalStorageHistory,JSON.stringify(searchMsg));
    location.assign(searchHref);
  }
};

const uiOnClickSearch = (evt) => {
  //console.log('onMessageWSS::uiOnClickSearch evt=<', evt,'>');
  const text = evt.parentElement.parentElement.getElementsByTagName('input')[0].value.trim();
  //console.log('onMessageWSS::uiOnClickSearch text=<', text,'>');
  if(text) {
    const searchHref = replaceLocationSearchParams() + '?words=' + text + '&start=0&end=' + iConstOnePageResult;
    console.log('onMessageWSS::uiOnClickSearchIndex searchHref=<', searchHref,'>');
    localStorage.setItem(LocalStorageSearchKeyWordFromIndex,text);
    const searchMsg = { words:text,start:0,end:iConstOnePageResult};
    localStorage.setItem(LocalStorageHistory,JSON.stringify(searchMsg));
    location.assign(searchHref);
  }
};

const replaceLocationSearchParams = () =>{
  //console.log('onMessageWSS::replaceLocationSearchParams location.href=<', location.href,'>');  
  //console.log('onMessageWSS::replaceLocationSearchParams location.pathname=<', location.pathname,'>');
  const hrefArray = location.href.split(location.pathname);
  //console.log('onMessageWSS::replaceLocationSearchParams hrefArray=<', hrefArray,'>');
  return hrefArray[0] + location.pathname;
};

const uiOnClickSearchNextPage = (evt) => {
  console.log('onMessageWSS::uiOnClickSearchNextPage evt=<', evt,'>');
};

const uiOnClickSearchPrevPage = (evt) => {
  console.log('onMessageWSS::uiOnClickSearchPrevPage evt=<', evt,'>');
};

const uiOnClickSearchGoToPage = (evt) => {
  console.log('onMessageWSS::uiOnClickSearchGoToPage evt=<', evt,'>');
};
