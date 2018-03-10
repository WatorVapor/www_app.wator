<script type="text/javascript">

  let graph_card = `<div class="card card-default text-center border border-danger">
    <div class="card-body">
      <h4 class="card-title">##sentence##</h4>
      <img class="card-img-bottom" src="##graph##.svg" alt="Card image cap">
    </div>
    <div class="card-footer">
      <a href="##graph##.svg" target="_blank" class="btn btn-primary">##wai_participle.opengraph##</a>
      <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.wator.xyz/##graph##.png" target="_blank" class="btn btn-primary">##wai_participle.facebook##</a>
    </div>
  </div>`;
    

  function onUpdateData(msg) {
    console.log('onUpdateData:msg=<',msg,'>');
    $( ".ui-update-toggle" ).toggleClass('d-none');
    $( "#ui-update-all-words" ).text('');
    if(msg.wai && typeof msg.wai === 'object') {
      msg.wai.forEach(function(wai,index,ar){
        console.log('onUpdateData:wai=<',wai,'>');
        //console.log('onUpdateData:index=<',index,'>');
        //console.log('onUpdateData:ar=<',ar,'>');
        if(wai.sentence) {
          let oldText = $( "#ui-update-all-words" ).text();
          $( "#ui-update-all-words" ).text(oldText + wai.sentence);
        } else {
          if(wai.input) {
            let oldText = $( "#ui-update-all-words" ).text();
            $( "#ui-update-all-words" ).text(oldText + wai.input);
          }
        }
        if(wai.graph){
          let new_graph_card = '';
          if(wai.sentence) {
            new_graph_card = graph_card.replace(/##sentence##/g,wai.sentence);
          }
          new_graph_card = new_graph_card.replace(/##graph##/g,wai.graph);
          let btn_text_opengraph = $("#ui-update-opengraph").text();
          new_graph_card = new_graph_card.replace('##wai_participle.opengraph##',btn_text_opengraph);
          let btn_text_facebook = $("#ui-update-facebook").text();
          new_graph_card = new_graph_card.replace('##wai_participle.facebook##',btn_text_facebook);
          $( "#ui-update-graph" ).append(new_graph_card);
        }
        if(wai.tts){
          createTTS(wai.tts);
        }
     });
    }
    if(msg.m3u8 && typeof msg.m3u8 === 'string') {
      console.log('onUpdateData:msg.tts=<',msg.m3u8,'>');
      let audioElem = document.getElementById('ui-update-all-words-tts');
      audioElem.src = 'https://www.wator.xyz/' + msg.m3u8;
   }
  }
  function createTTS(tts) {
    console.log('createTTS:tts=<',tts,'>');
  }
</script>
