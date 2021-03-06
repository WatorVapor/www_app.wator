<script type="text/javascript">

  let graph_card = `<div class="card card-default text-center border border-danger">
    <div class="card-body">
      <h4 class="card-title">##sentence##</h4>
      <img class="card-img-bottom" src="##graph##.svg" alt="Card image cap">
    </div>
    <div class="card-footer">
      <a href="##graph##.svg" target="_blank" class="btn btn-primary">
        ##wai_participle.opengraph##
      </a>
      <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.wator.xyz/##graph##.png" 
        target="_blank" class="btn btn-primary">
        ##wai_participle.facebook##
      </a>
    </div>
  </div>`;
    

  function onUpdateData(msg) {
    console.log('onUpdateData:msg=<',msg,'>');
    $( ".ui-update-toggle" ).toggleClass('d-none');
    let input = '';
    let wordCut = '';
    if(msg.wai && typeof msg.wai === 'object') {
      let ttsTotal = {list:[]};
      msg.wai.forEach(function(wai,index,ar){
        console.log('onUpdateData:wai=<',wai,'>');
        ttsTotal.lang = wai.lang;
        //console.log('onUpdateData:index=<',index,'>');
        //console.log('onUpdateData:ar=<',ar,'>');
        if(wai.sentence) {
           wordCut += '%' + wai.sentence;
        } else {
          if(wai.input) {
            wordCut += '%' + wai.input;
          }
        }
        if(wai.input) {
          input += wai.input;
        }
        if(wai.graph){
          let new_graph_card = '';
          if(wai.sentence) {
            new_graph_card = graph_card.replace(/##sentence##/g,wai.sentence);
          }
          new_graph_card = new_graph_card.replace(/##graph##/g,wai.graph);
          let textWeiBo= '中文分词：' + wai.input + '----------' + wai.sentence;
          new_graph_card = new_graph_card.replace(/##text##/g,textWeiBo);
          let btn_text_opengraph = $("#ui-update-opengraph").text();
          new_graph_card = new_graph_card.replace('##wai_participle.opengraph##',btn_text_opengraph);
          let btn_text_facebook = $("#ui-update-facebook").text();
          new_graph_card = new_graph_card.replace('##wai_participle.facebook##',btn_text_facebook);
          let btn_text_weibo = $("#ui-update-weibo").text();
          new_graph_card = new_graph_card.replace('##wai_participle.weibo##',btn_text_weibo);
          $( "#ui-update-graph" ).append(new_graph_card);
        }
        if(wai.tts){
          for(let index in wai.tts) {
            let clip = wai.tts[index];
            ttsTotal.list.push(clip);
          }
        }
     });
     console.log('onUpdateData:input=<',input,'>');
     console.log('onUpdateData:wordCut=<',wordCut,'>');
     let app1 = new Vue({
          el: '#vue-ui-update-all-words',
          data: {
              all_words: wordCut
          }
     });
     let weibo = 'http://service.weibo.com/share/share.php?url=https://www.wator.xyz/wai/text/participle&appkey=4192536820&title=';
     weibo += '中文分词：';
     weibo += input;
     weibo += '----------';
     weibo += wordCut;
     weibo += '';
     console.log('onUpdateData:weibo=<',weibo,'>');
     let app2 = new Vue({
          el: '#vue-ui-update-sns-weibo',
          data: {
              weibo_url: weibo
          }
     });
     
     createTTS(ttsTotal);
    }
    if(msg.m3u8 && typeof msg.m3u8 === 'string') {
      console.log('onUpdateData:msg.tts=<',msg.m3u8,'>');
   }
  }
</script>
