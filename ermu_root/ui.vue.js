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

const gResultFrameRows = [];
let gResultFrameRowsApp = false;

const onShowSearchResultFrameRow = (cid) => {
  //console.log('ui.vue::onShowSearchResultFrameRow cid=<', cid,'>');
  const idElem = {
    spinner:'spinner-' + cid,
    frame:'frame-' + cid,
    title:'title-' + cid,
    freq:'freq-' + cid,
    href:'href-' + cid,
    summary:'summary-' + cid
  };
  gResultFrameRows.push(idElem);
  if(gResultFrameRowsApp === false) {
    gResultFrameRowsApp = new Vue({
      el: '#vue-ui-app-rows-result-frame',
      data: {
        searchResultCIDRows: gResultFrameRows
      }
    });    
  }
  $('#vue-ui-app-rows-result-frame').removeClass("d-none");
  $('#search-progress-spinner').addClass("d-none");

}


const onShowSearchResultOneRow = (cid,result) => {
  //console.log('ui.vue::onShowSearchResultOneRow cid=<', cid,'>');
  //console.log('ui.vue::onShowSearchResultOneRow result=<', result,'>');
  const contentJ = JSON.parse(result.content);
  const summaryArray = contentJ.summary.split(contentJ.word);
  //console.log('ui.vue::onShowTopResultApp summaryArray=<', summaryArray,'>');
  let summaryColor = '';
  for(const sumClip of summaryArray) {
    summaryColor += sumClip;
    summaryColor += '<span class="text-danger">';
    summaryColor += contentJ.word;
    summaryColor += '</span>';
  }
  const frameid = '#frame-' + cid;
  //console.log('ui.vue::onShowSearchResultOneRow frameid=<', frameid,'>');
  $(frameid).removeClass("d-none");
  const spinnerid = '#spinner-' + cid;
  //console.log('ui.vue::onShowSearchResultOneRow spinnerid=<', spinnerid,'>');
  $(spinnerid).addClass("d-none");
  
  const freqid = '#freq-' + cid;
  //console.log('ui.vue::onShowSearchResultOneRow freqid=<', freqid,'>');
  $(freqid).text(contentJ.freq);
  
  const titleid = '#title-' + cid;
  //console.log('ui.vue::onShowSearchResultOneRow titleid=<', titleid,'>');
  let tiltle = contentJ.title;
  if(!tiltle) {
    tiltle = contentJ.href;
  }
  $(titleid).text(tiltle);
  
  const hrefid = '#href-' + cid;
  //console.log('ui.vue::onShowSearchResultOneRow hrefid=<', hrefid,'>');
  $(hrefid).attr('href',contentJ.href);
  
  const summaryid = '#summary-' + cid;
  //console.log('ui.vue::onShowSearchResultOneRow summaryid=<', summaryid,'>');
  $(summaryid).html(summaryColor);  
}
