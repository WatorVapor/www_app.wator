const gResultPages = [];
let gResultPagesApp = false;
let gTotalPage = 0;

const onShowStatsResultApp = (msg) =>{
  console.log('ui.vue::onShowStatsResultApp msg=<', msg,'>');
  while(gResultPages.length > 0) {
      gResultPages.pop();
  }
  const totalPage = Math.ceil(parseInt(msg.totalResult)/iConstOnePageResult);
  for(let page = 1;page <= totalPage;page++) {
    gResultPages.push({number:page});
  }
  gTotalPage = parseInt(msg.totalResult);
  console.log('ui.vue::onShowStatsResultApp gTotalPage=<', gTotalPage,'>');
  if(gResultPagesApp === false) {
    gResultPagesApp = new Vue({
      el: '#vue-ui-app-pages-nav-result',
      data: {
        pages: gResultPages,
        total:gTotalPage
      }
    });    
  } else {
    console.log('ui.vue::onShowStatsResultApp gResultPagesApp=<', gResultPagesApp,'>');
    if(gTotalPage > gResultPagesApp.total) {
      gResultPagesApp.total = gTotalPage;
    }
  }
  $('#vue-ui-app-pages-nav-result').removeClass("d-none");
}

const onShowSearchResultApp = (msg,words) =>{
  console.log('ui.vue::onShowSearchResultApp msg=<', msg,'>');
  console.log('ui.vue::onShowSearchResultApp words=<', words,'>');
}

/*
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
*/ 

const gResultFrameRows = [];
let gResultFrameRowsApp = false;

const onShowSearchResultFrameRow = (cid) => {
  console.log('ui.vue::onShowSearchResultFrameRow cid=<', cid,'>');
  const idElem = {
    spinner:'spinner-' + cid,
    frame:'frame-' + cid,
    title:'title-' + cid,
    href:'href-' + cid,
    summary:'summary-' + cid
  };
  gResultFrameRows.push(idElem);
  if(gResultFrameRowsApp === false) {
    gResultFrameRowsApp = new Vue({
      el: '#vue-ui-app-rows-result-frame',
      data: {
        searchResultIpfsRows: gResultFrameRows
      }
    });    
  }
  $('#vue-ui-app-rows-result-frame').removeClass("d-none");
  $('#search-progress-spinner').addClass("d-none");

}


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
  const frameid = '#frame-' + cid;
  console.log('ui.vue::onShowSearchResultOneRow frameid=<', frameid,'>');
  $(frameid).removeClass("d-none");
  const spinnerid = '#spinner-' + cid;
  console.log('ui.vue::onShowSearchResultOneRow spinnerid=<', spinnerid,'>');
  $(spinnerid).addClass("d-none");
  const titleid = '#title-' + cid;
  console.log('ui.vue::onShowSearchResultOneRow titleid=<', titleid,'>');
  let tiltle = result.title;
  if(!tiltle) {
    tiltle = result.href;
  }
  $(titleid).text(tiltle);
  
  const hrefid = '#href-' + cid;
  console.log('ui.vue::onShowSearchResultOneRow hrefid=<', hrefid,'>');
  $(hrefid).attr('href',result.href);
  
  const summaryid = '#summary-' + cid;
  console.log('ui.vue::onShowSearchResultOneRow summaryid=<', summaryid,'>');
  $(summaryid).html(summaryColor);  
}
