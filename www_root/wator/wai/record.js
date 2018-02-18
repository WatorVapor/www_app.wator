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
  mr.ondataavailable = function (e) {
    console.log('ondataavailable:e=<',e,'>');
    console.log('ondataavailable:phoneme=<',phoneme,'>');
    console.log('ondataavailable:window.URL=<',window.URL,'>');
    const chunks = [];
    chunks.push(e.data);
    const blob = new Blob(chunks, { type: 'audio/webm' });
    let urlBlob = window.URL.createObjectURL(blob);
    console.log('ondataavailable:urlBlob=<',urlBlob,'>');
    //saveToFile(urlBlob,phoneme);
    uploadSlice(blob,phoneme);
  }
  mr.start();
  setTimeout(function(){
    mr.stop();
  },1000);
}
function onMediaError(e) {
  console.error('media error e=<', e,'>');
}

