function onUpdateData(msg) {
  console.log('onUpdateData:msg=<',msg,'>');
}
function onClickRecordBtn(elem) {
  console.log('onClickRecordBtn:elem=<',elem,'>');
  let root = elem.parentElement.parentElement;
  //console.log('onClickRecordBtn:root=<',root,'>');
  let phoneme = root.getElementsByTagName('h4')[0].textContent;
  console.log('onClickRecordBtn:phoneme=<',phoneme,'>');
  doAudioRecord(phoneme);
}

function doAudioRecord(phoneme) {
  console.log('doAudioRecord:phoneme=<',phoneme,'>');
  let mediaConstraints = { audio: true};
  navigator.getUserMedia(mediaConstraints, function(stream) {
      onMediaSuccess(stream,phoneme);
    }, onMediaError);
}
function onMediaSuccess(stream,phoneme) {
  let mr = new MediaRecorder(stream);
  mr.mimeType = 'audio/webm'; // audio/webm or audio/ogg or audio/wav
  let chunks = {};
  let clipIndex = 0;
  mr.ondataavailable = function (e) {
    //console.log('ondataavailable:e=<',e,'>');
    //console.log('ondataavailable:phoneme=<',phoneme,'>');
    //console.log('ondataavailable:window.URL=<',window.URL,'>');
    chunks[clipIndex++] = e.data;
   //saveToFile(chunks,phoneme);
   //uploadSlice(chunks,phoneme);
  }
  mr.onerror = function (e) {
    console.log('error:e=<',e,'>');
  }
  mr.onstart = function (e) {
    console.log('onstart:e=<',e,'>');
  }
  mr.onstop = function (e) {
    console.log('onstop:e=<',e,'>');
  }
  mr.start(20);
  setTimeout(function(){
    mr.stop();
  },1000);
}
function onMediaError(e) {
  console.error('media error e=<', e,'>');
}

