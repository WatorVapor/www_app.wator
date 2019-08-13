
<div class="col-12" id="vue-ui-word-yes-no">
  <div class="row justify-content-center mt-5 mb-5" v-for="wordRow in teachRows">
    <div class="col-5" v-for="wordCell in wordRow">
      <div class="card text-center" style="width:100%;">
        <div class="card-header">
          <h2><span class="badge badge-primary">@{{wordCell.word}}</span></h2>
        </div>      
        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-6">
              <button class="btn btn-success" type="button" onclick="onUIClickWordYes(this)">
                是中文单词<span class="badge badge-primary d-none" >@{{wordCell.word}}</span>
              </button>
            </div>
            <div class="col-6">
              <button class="btn btn-danger" type="button" onclick="onUIClickWordNo(this)">
                非中文单词<span class="badge badge-primary d-none">@{{wordCell.word}}</span>
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
  const onUITeachWordsYesNo = (words) => {
    console.log('onUITeachWordsYesNo words=<',words,'>');
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
        teachRows: teachRows
      }
    })
  }
  const onUIClickWordYes = (elem) => {
    console.log('onUIClickWordYes elem=<',elem,'>');
    elem.setAttribute('disabled','disabled');
    let word = getWordInsideBtn(elem);
    console.log('onUIClickWordYes word=<',word,'>');
    teachWordYes(word);
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
