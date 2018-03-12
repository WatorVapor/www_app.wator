<script type="text/javascript">


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
  audio.load();
  audio.muted = true;
  audio.play();
  return audio;
}

function onClickTTS(elem) {
  //console.log('onClickTTS:elem=<',elem,'>');
  let audioList = document.getElementsByClassName('ui-update-tts-one-clip');
  //console.log('onClickTTS:audioList=<',audioList,'>');
  let root = elem.parentElement.parentElement;
  console.log('onClickTTS:root=<',root,'>');
  let speed = parseFloat(root.getElementsByTagName('input')[0].value);
  doPlayTTS(audioList,0,speed);
}

function doPlayTTS(playList,index,speed) {
  //console.log('doPlayTTS:playList=<',playList,'>');
  if(playList.length > index) {
    let audio = playList[index];
    audio.muted = false;
    //console.log('doPlayTTS:audio=<',audio,'>');
    console.log('doPlayTTS:audio.duration=<',audio.duration,'>');
    /*
    audio.addEventListener("ended", function(){
      doPlayTTS(playList,index+1,speed);
    });
    */
    let stop = audio.duration *1000 + 10;
    setTimeout(function(){
      stopPlayTTS(playList,index);
      doPlayTTS(playList,index+1,speed);
    },stop);
    audio.playbackRate = speed;
    audio.play();
  }
}
function stopPlayTTS(playList,index) {
  if(playList.length > index) {
    let audio = playList[index];
    audio.pause();
  }
}

</script>
