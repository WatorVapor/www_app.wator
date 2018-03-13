<script src="https://unpkg.com/ipfs-api/dist/index.js"></script>

<script type="text/javascript">
const Buffer = window.IpfsApi().Buffer;
let ipfs = window.IpfsApi({host:'www.wator.xyz', port:'443', protocol: 'https'});
let ttsCached = false;
ipfs.id(function (err, identity) {
  if (err) {
    throw err
  }
  console.log('ipfs.id:identity=<',identity,'>');
  ipfs.isReadyMask = true;
  if(ttsCached) {
    setTimeout(function(){
      createTTS(ttsCached);
    },1)
  }
});


function createTTS(tts) {
  if(ipfs.isReadyMask) {
    //console.log('createTTS:tts=<',tts,'>');
    let clipsElem = document.getElementById('ui-update-tts-all-clips');
    //console.log('onClickTTS:clipsElem=<',clipsElem,'>');
    if(tts.length > 0){
      createClipsElement(clipsElem,0,tts);
    }
  } else {
    ttsCached = tts;
  }
}

function createClipsElement(clipsElem,index,tts) {
  //console.log('createClipsElement:clip=<',clip,'>');
  let clip = tts[index];
  ipfs.files.cat(clip,function(err, file){
    if (err) {
      throw err;
    }
    //console.log('createClipsElement:: ipfs.files.cat file=<',file,'>');
    let blob = new Blob([file], { type: 'audio/webm' });
    let urlBlob = window.URL.createObjectURL(blob);
    let audio = document.createElement('audio');
    audio.className = 'ui-update-tts-one-clip';
    audio.setAttribute('id','ui-update-tts-one-clip-' + index);
    audio.src = urlBlob;
    audio.setAttribute('type','audio/webm');
    console.log('createClipsElement:audio=<',audio,'>');
    clipsElem.appendChild(audio);
    if(tts.length > index +1) {
      createClipsElement(clipsElem,index +1,tts)
    } else {
      $( '.ui-update-tts-enable-audio' ).removeClass( 'd-none' );
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
    console.log('doPlayTTS:index=<',index,'>');
    console.log('doPlayTTS:audio.duration=<',audio.duration,'>');
    
    /*
    audio.index = index;
    audio.onended = function (evt){
      console.log('doPlayTTS:audio.onended evt=<',evt,'>');
      console.log('doPlayTTS:audio.onended evt.target.index=<',evt.target.index,'>');
      doPlayTTS(playList,evt.target.index + 1,speed);
    }
    */
    audio.playbackRate = speed;
    audio.play();
    
    let stop = audio.duration *1000 + 50;
    let timer = setInterval(function(){
      console.log('doPlayTTS:audio.currentTime <',audio.currentTime,'>');
      if(audio.currentTime >= audio.duration - 0.01) {
        clearInterval(timer);
        doPlayTTS(playList,index+1,speed);
      }
    },20);
    /*
    setTimeout(function(){
      doPlayTTS(playList,index+1,speed);
    },stop);
    */
    
  }
}
function stopPlayTTS(playList,index) {
  if(playList.length > index) {
    let audio = playList[index];
    audio.pause();
  }
}

</script>
