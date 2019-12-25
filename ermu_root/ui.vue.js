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
    el: '#vue-ui-app-top-search',
    data: {
      history: historyText
    }
  });  
};

const gResultRows = [];
let gResultApp = false;
const onShowTopResultApp = (result) =>{
  console.log('ui.vue::onShowTopResultApp result=<', result,'>');
  gResultRows.push(result);
  console.log('ui.vue::onShowTopResultApp gResultRows=<', gResultRows,'>');
  if(gResultApp === false) {
    gResultApp = new Vue({
      el: '#vue-ui-app-top-result',
      data: {
        rows: gResultRows
      }
    });    
  }
  $("#vue-ui-app-top-result").removeClass("d-none");
};
