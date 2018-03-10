<script type="text/javascript">

function onClickTTS(elem) {
  //console.log('onClickTTS:elem=<',elem,'>');
  let audioList = document.getElementsByClassName('ui-update-tts-one-clip');
  //console.log('onClickTTS:audioList=<',audioList,'>');
  doPlayTTS(audioList,0);
}

function createTTS(tts) {
  //console.log('createTTS:tts=<',tts,'>');
  let clipsElem = document.getElementById('ui-update-tts-all-clips');
  //console.log('onClickTTS:clipsElem=<',clipsElem,'>');
  for(let index in tts) {
    let clip = tts[index];
    //console.log('createTTS:clip=<',clip,'>');
    let audioElem = createClipsElement(clip);
    clipsElem.appendChild(audioElem);
  }
}
function createClipsElement(clip) {
  //console.log('createClipsElement:clip=<',clip,'>');
  let audio = document.createElement('audio');
  audio.src = 'https://ipfs.io/ipfs/' + clip;
  audio.className = 'ui-update-tts-one-clip';
  //console.log('createClipsElement:audio=<',audio,'>');
  audio.muted = true;
  audio.play();
  return audio;
}


function doPlayTTS(playList,index) {
  //console.log('doPlayTTS:playList=<',playList,'>');
  if(playList.length > index) {
    let audio = playList[index];
    audio.muted = false;
    //console.log('doPlayTTS:audio=<',audio,'>');
    audio.addEventListener("ended", function(){
      doPlayTTS(playList,index+1);
    });
    audio.playbackRate = 2;
    audio.play();
  }
}

</script>
