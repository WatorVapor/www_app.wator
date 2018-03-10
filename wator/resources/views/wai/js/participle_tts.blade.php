<script type="text/javascript">

function onClickTTS(elem) {
  console.log('onClickTTS:elem=<',elem,'>');
  let audioElem = document.getElementById('ui-update-tts-audio');
  console.log('onClickTTS:audioElem=<',audioElem,'>');
  audioElem.play();
}

function createTTS(tts) {
  console.log('createTTS:tts=<',tts,'>');
  let audioElem = document.getElementById('ui-update-tts-audio');
  console.log('onClickTTS:audioElem=<',audioElem,'>');
  for(let index in tts) {
    let clip = tts[index];
    console.log('createTTS:clip=<',clip,'>');
    let sourceElem = createClipsElement(clip);
    audioElem.appendChild(sourceElem);
  }
}
function createClipsElement(clip) {
  console.log('createClipsElement:clip=<',clip,'>');
  let audio = document.createElement('source');
  audio.setAttribute('src','https://ipfs.io/ipfs/' + clip);
  console.log('createClipsElement:audio=<',audio,'>');
  return audio;
}

/*
function doPlayTTS(playList,index) {
  console.log('doPlayTTS:playList=<',playList,'>');
  if(playList.length > index) {
    let audio = playList[index];
    console.log('doPlayTTS:audio=<',audio,'>');
    audio.addEventListener("ended", function(){
      doPlayTTS(playList,index+1);
    });
    audio.playbackRate = 2;
    audio.play();
  }
}
*/
</script>
