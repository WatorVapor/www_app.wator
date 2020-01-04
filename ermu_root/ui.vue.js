$( document ).ready(function() {
  onDocumentReadyUI();
});

document.addEventListener('DOMContentLoaded',(evt) =>{
  onDocumentReadyUI(evt);
});


const onDocumentReadyUI = (evt) =>{
  console.log('ui.vue::onDocumentReadyUI evt=<', evt,'>');
  onShowTopSearchApp();
};

const onShowTopSearchApp = () =>{
  console.log('ui.vue::onShowTopSearchApp');
  let historyText = getHistory();
  if(!historyText) {
    historyText = '搜索';
  }
  const app = new Vue({
    el: '#vue-ui-app-search-keywords-input',
    data: {
      history: historyText
    }
  });  
};

const gResultRows = [];
let gResultRowsApp = false;

const gResultPages = [];
let gResultPagesApp = false;

const onShowTopResultApp = (result) =>{
  console.log('ui.vue::onShowTopResultApp result=<', result,'>');
  gResultRows.push(result);
  console.log('ui.vue::onShowTopResultApp gResultRows=<', gResultRows,'>');
  if(gResultRowsApp === false) {
    gResultRowsApp = new Vue({
      el: '#vue-ui-app-rows-result',
      data: {
        rows: gResultRows
      }
    });    
  }
  $('#vue-ui-app-rows-result').removeClass("d-none");

  if(gResultPagesApp === false) {
    gResultPagesApp = new Vue({
      el: '#vue-ui-app-pages-nav-result',
      data: {
        pages: gResultPages
      }
    });    
  }
  $('#vue-ui-app-pages-nav-result').removeClass("d-none");

};

const onClearTopResultApp = () =>{
  while(gResultRows.length > 0) {
      gResultRows.pop();
  }
  //console.log('ui.vue::onShowTopResultApp gResultRows=<', gResultRows,'>');
};

