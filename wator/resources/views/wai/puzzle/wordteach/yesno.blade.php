<div class="col-12" id="vue-ui-word-yes-no">
  <div class="row justify-content-center" v-for="wordRow in teachRows">
    <div class="col-4" v-for="wordCell in wordRow">
      <div class="card" style="width:100%;">
        <div class="card-header">
        </div>      
        <div class="card-body">
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
      if(index % 3 === 2) {
        teachRows.push(teachRow);
        teachRow = [];
      }
    }
    if(teachRow.length > 0) {
      teachRows.push(teachRow);
    }
    const app = new Vue({
      el: '#vue-ui-word-yes-no',
      data: {
        teachRows: teachRows
      }
    })
  }
</script>
