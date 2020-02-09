/*
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
*/
const gResultPages = [];
let gResultPagesApp = false;

const onShowStatsResultApp = (msg) =>{
  console.log('ui.vue::onShowStatsResultApp msg=<', msg,'>');

  while(gResultPages.length > 0) {
      gResultPages.pop();
  }
 

  const totalPage = Math.ceil(parseInt(msg.totalResult)/iConstOnePageResult);
  for(let page = 1;page <= totalPage;page++) {
    gResultPages.push({number:page});
  }

  if(gResultPagesApp === false) {
    gResultPagesApp = new Vue({
      el: '#vue-ui-app-pages-nav-result',
      data: {
        pages: gResultPages,
        total:parseInt(msg.totalResult)
      }
    });    
  }
  $('#vue-ui-app-pages-nav-result').removeClass("d-none");
}

const onShowSearchResultApp = (msg,words) =>{
  console.log('ui.vue::onShowSearchResultApp msg=<', msg,'>');
  console.log('ui.vue::onShowSearchResultApp words=<', words,'>');
}

const gResultRows = [];
let gResultRowsApp = false;

const onShowSearchResultOneRow = (cid,result) => {
  //console.log('ui.vue::onShowSearchResultOneRow cid=<', cid,'>');
  //console.log('ui.vue::onShowSearchResultOneRow result=<', result,'>');
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
  
} 

