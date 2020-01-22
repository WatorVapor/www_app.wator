const gResultRows = [];
let gResultRowsApp = false;
let gResultTotalRowCounter = 0;

const gResultPages = [];
let gResultPagesApp = false;


const onShowTopResultApp = (result) =>{
  console.log('ui.vue::onShowTopResultApp result=<', result,'>');
  const summaryArray = result.summary.split(result.word);
  //console.log('ui.vue::onShowTopResultApp summaryArray=<', summaryArray,'>');
  let summaryColor = '';
  for(const sumClip of summaryArray) {
    summaryColor += sumClip;
    summaryColor += '<span class="text-danger">';
    summaryColor += result.word;
    summaryColor += '</span>';
  }
  //console.log('ui.vue::onShowTopResultApp summaryColor=<', summaryColor,'>');
  result.summary = summaryColor;
  if(!result.title) {
    result.title = result.href;
  }
  gResultRows.push(result);
  //console.log('ui.vue::onShowTopResultApp gResultRows=<', gResultRows,'>');
  if(gResultRowsApp === false) {
    gResultRowsApp = new Vue({
      el: '#vue-ui-app-rows-result',
      data: {
        searchResultRows: gResultRows
      }
    });    
  }
  $('#vue-ui-app-rows-result').removeClass("d-none");
  $('#search-progress-spinner').addClass("d-none");

  while(gResultPages.length > 0) {
      gResultPages.pop();
  }
  console.log('ui.vue::onShowTopResultApp gResultRows=<', gResultRows,'>');
  const totalPage = Math.ceil(gResultRows.length/iConstOnePageResult);
  for(let page = 1;page <= totalPage;page++) {
    gResultPages.push({number:page});
  }
  console.log('ui.vue::onShowTopResultApp totalPage=<', totalPage,'>');
  gResultTotalRowCounter = gResultRows.length;
  console.log('ui.vue::onShowTopResultApp gResultTotalRowCounter=<', gResultTotalRowCounter,'>');
  if(gResultPagesApp === false) {
    gResultPagesApp = new Vue({
      el: '#vue-ui-app-pages-nav-result',
      data: {
        pages: gResultPages,
        searchResultRows:gResultRows
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

