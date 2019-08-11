<div class="col-12" id="vue-ui-word-yes-no">
  <div class="row justify-content-center" v-for="wordRow in teachRows">
    <div class="col-3" v-for="wordCell in wordRow">
      <div class="card" style="width:100%;">
        <div class="card-header">
        </div>      
        <div class="card-body">
        </div>
      </div>
    </div>
  </div>
</div>

<script src="/wator/wai/teach/word.js" type="text/javascript"></script>

<script>
  const onTeachUIWords = (words) => {
    let teachRows = {};
    const app = new Vue({
      el: '#vue-ui-word-yes-no',
      data: {
        teachRows: teachRows
      }
    })    
  }
</script>
