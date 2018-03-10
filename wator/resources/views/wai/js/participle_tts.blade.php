<script type="text/javascript">

function onClickTTS(elem) {
  console.log('onClickTTS:elem=<',elem,'>');
  let allClipsElem = document.getElementsByClassName('ui-update-tts-one-clip');
  console.log('onClickTTS:allClipsElem=<',allClipsElem,'>');
  doPlayTTS(allClipsElem);
}

function createTTS(tts) {
  console.log('createTTS:tts=<',tts,'>');
  let clipsElem = document.getElementById('ui-update-all-clips');
  console.log('onClickTTS:clipsElem=<',clipsElem,'>');
  for(let index in tts) {
    let clip = tts[index];
    console.log('createTTS:clip=<',clip,'>');
    let audioElem = createClipsElement(clip);
    clipsElem.appendChild(audioElem);
  }
}
function createClipsElement(clip) {
  console.log('createClipsElement:clip=<',clip,'>');
  let audio = new Audio();
  audio.src = 'https://ipfs.io/ipfs/' + clip;
  audio.className = "ui-update-tts-one-clip";
  console.log('createClipsElement:audio=<',audio,'>');
  return audio;
}
function doPlayTTS(playList) {
  console.log('doPlayTTS:playList=<',playList,'>');
}
</script>
