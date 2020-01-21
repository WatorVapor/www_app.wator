const gResultRows = [];
let gResultRowsApp = false;

const gResultPages = [];
let gResultPagesApp = false;

const onShowTopResultApp = (result) =>{
  //console.log('ui.vue::onShowTopResultApp result=<', result,'>');
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
  gResultRows.push(result);
  //console.log('ui.vue::onShowTopResultApp gResultRows=<', gResultRows,'>');
  if(gResultRowsApp === false) {
    gResultRowsApp = new Vue({
      el: '#vue-ui-app-rows-result',
      data: {
        rows: gResultRows
      }
    });    
  }
  $('#vue-ui-app-rows-result').removeClass("d-none");

  while(gResultPages.length > 0) {
      gResultPages.pop();
  }
  //console.log('ui.vue::onShowTopResultApp gResultRows=<', gResultRows,'>');
  const totalPage = Math.ceil(gResultRows.length/iConstOnePageResult);
  for(let page = 1;page <= totalPage;page++) {
    gResultPages.push({number:page});
  }
  console.log('ui.vue::onShowTopResultApp totalPage=<', totalPage,'>');
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

