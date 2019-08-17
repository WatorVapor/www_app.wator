
<div class="col-12" id="vue-ui-word-yes-no">
  <div class="row justify-content-center mt-5 mb-5">
    <div class="col-4 text-center">
      <span class="badge badge-success"><h1>@{{current}} / @{{total}} </h1></span>
    </div>
  </div>
  <div class="row justify-content-center mt-5 mb-5" v-for="wordRow in teachRows">
    <div class="col-5" v-for="wordCell in wordRow">
      <div class="card text-center" style="width:100%;">
        <div class="card-header">
            <span class="badge badge-primary">
              <h1>@{{wordCell.word}}</h1>
            </span>
        </div>      
        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-6">
              <button class="btn btn-danger btn-block" type="button" onclick="onUIClickWordNo(this)">
                <h3>非中文单词<h3>
                <span class="badge badge-primary d-none">@{{wordCell.word}}</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="/wator/secauth/js/auth.js" type="text/javascript"></script>
<script src="/wator/wai/teach/word.js" type="text/javascript"></script>

<script>
  const onUITeachWordsYesNo = (msgJson) => {
    console.log('onUITeachWordsYesNo msgJson=<',msgJson,'>');
    const words = msgJson.words;
    const teachRows = [];
    let teachRow = [];
    for(let index = 0;index < words.length;index++) {
      teachRow.push(words[index]);
      if(index % 2 === 1) {
        teachRows.push(teachRow);
        teachRow = [];
      }
    }
    if(teachRow.length > 0) {
      teachRows.push(teachRow);
    }
    console.log('onUITeachWordsYesNo teachRows=<',teachRows,'>');
    const app = new Vue({
      el: '#vue-ui-word-yes-no',
      data: {
        teachRows: teachRows,
        total:msgJson.total,
        current:msgJson.current
      }
    })
  }
  const getWordInsideBtn = (elem) => {
    let wordElem = elem.getElementsByTagName('span')[0];
    //console.log('onUIClickWordYes wordElem=<',wordElem,'>');
    let word = wordElem.textContent.trim();
    //console.log('onUIClickWordYes word=<',word,'>');
    return word;
  }
  const onUIClickWordNo = (elem) => {
    console.log('onUIClickWordNo elem=<',elem,'>');
    elem.setAttribute('disabled','disabled');
    let word = getWordInsideBtn(elem);
    console.log('onUIClickWordNo word=<',word,'>');
    teachWordNo(word);
  }
  
</script>
