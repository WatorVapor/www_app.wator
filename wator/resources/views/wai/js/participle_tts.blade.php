<script src="https://unpkg.com/ipfs-api/dist/index.js"></script>

<script type="text/javascript">
const Buffer = window.IpfsApi().Buffer;
let ipfs = window.IpfsApi({host:'www.wator.xyz', port:'443', protocol: 'https'});
ipfs.id(function (err, identity) {
  if (err) {
    throw err
  }
  console.log('ipfs.id:identity=<',identity,'>');
});


function createTTS(tts) {
  //console.log('createTTS:tts=<',tts,'>');
  let clipsElem = document.getElementById('ui-update-tts-all-clips');
  //console.log('onClickTTS:clipsElem=<',clipsElem,'>');
  if(tts.length > 0){
    createClipsElement(clipsElem,0,tts);
  }
}

function createClipsElement(clipsElem,index,tts) {
  //console.log('createClipsElement:clip=<',clip,'>');
  let clip = tts[index];
  ipfs.files.cat(clip,function(err, file){
    if (err) {
      throw err;
    }
    console.log('createClipsElement:: ipfs.files.cat file=<',file,'>');
    let blob = new Blob([file], { type: 'audio/webm' });
    let urlBlob = window.URL.createObjectURL(blob);
    let audio = document.createElement('audio');
    audio.className = 'ui-update-tts-one-clip';
    audio.src = urlBlob;
    audio.setAttribute('type','audio/webm');
    //console.log('createClipsElement:audio=<',audio,'>');
    clipsElem.appendChild(audio);
    if(tts.length > index +1) {
      createClipsElement(clipsElem,index +1,tts)
    }
  });
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
    console.log('doPlayTTS:audio=<',audio,'>');
    console.log('doPlayTTS:audio.duration=<',audio.duration,'>');
    
    /*
    audio.addEventListener('ended', function(){
      doPlayTTS(playList,index+1,speed);
    });
    */

    let stop = audio.duration *1000 - 10;
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
