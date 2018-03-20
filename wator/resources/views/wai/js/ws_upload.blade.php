<!--
<script src="https://unpkg.com/ipfs-api/dist/index.js"></script>
-->


<script type="text/javascript">
//const Buffer = window.IpfsApi().Buffer;


let uriStorage = "wss://" + location.host + "/wator/storage";
let wsStorage = new WebSocket(uriStorage);
wsStorage.onopen = onStorageOpen_;
wsStorage.onmessage = onStorageMessage_;
wsStorage.onclose = onStorageClose_;
wsStorage.onerror = onStorageError_;

function onStorageOpen_(evt) {
  console.log('onStorageOpen_:evt=<',evt,'>');
}
function onStorageMessage_(evt) {
  console.log('onStorageMessage_:evt.data=<',evt.data,'>');
  let jsonMsg = JSON.parse(evt.data);
  console.log('onStorageMessage_:jsonMsg=<',jsonMsg,'>');
  if(jsonMsg) {
    uploadIPFSInfo(jsonMsg);
  }
}
function onStorageClose_(evt) {
  console.log('onStorageClose_:evt=<',evt,'>');
}
function onStorageError_(evt) {
  console.log('onStorageError_:evt=<',evt,'>');
}



function onClickDoneBtn(elem) {
  console.log('onClickDoneBtn:elem=<',elem,'>');
  $( '#wai-recoder-clip-done' ).addClass( 'd-none' );
  uploadSliceToLocal(gClipChunks,'{{ $phoneme }}');
  //uploadInfo('none');
}
function uploadSliceToLocal(chunks,phoneme) {
  const blob = new Blob(chunks, { type: 'audio/webm' });
  const reader = new FileReader();  
  reader.addEventListener('loadend', (e) => {
    const buffer = e.srcElement.result;
    //let bufText = Buffer.from(buffer);
    //console.log('uploadSliceToLocal:bufText=<',bufText,'>');
    console.log('uploadSliceToLocal:buffer=<',buffer,'>');
    localStorage.setItem('wai/train/audio/clip/' + '{{ $lang }}/' + phoneme,bufferToBase64(buffer));
    $( '#wai-recoder-clip-done-next' ).click();
  }); 
  reader.readAsArrayBuffer(blob);
}
function onClickDoneBtn(elem) {
  console.log('onClickDoneBtn:elem=<',elem,'>');
  $( '#wai-recoder-clip-done' ).addClass( 'd-none' );
  uploadSliceToLocal(gClipChunks,'{{ $phoneme }}');
}
function onClickUploadBtn(elem) {
  console.log('onClickDoneBtn:elem=<',elem,'>');
  $( '#wai-recoder-clip-upload' ).addClass( 'd-none' );
  $( '#wai-recoder-clip-animate' ).removeClass( 'd-none' );
  uploadLocalToIpfs();
}


function uploadLocalToIpfs() {
  let files = [];
  let counter = 0;
  for (let key in localStorage){
    if(key.startsWith('wai/train/audio/clip/')){
      console.log('uploadLocalToIpfs::key=<',key,'>');
      let bufStorage = localStorage.getItem(key);
      let params = key.split('/');
      let phoneme = params[params.length -1];
      let lang = params[params.length -2];
      let file = {
        path:  phoneme + '@' + lang,
        content: bufStorage
      };
      files.push(file);
      if(counter++ >= 9) {
        break;
      }
    }
  }
  console.log('uploadLocalToIpfs::files=<',files,'>');
  if(wsStorage.readyState) {
    wsStorage.send(JSON.stringify(files));
  }
}



function uploadIPFSInfo(ipfs) {
  console.log('uploadIPFSInfo::ipfs=<',ipfs,'>');
  $( '#wai-recoder-clip-animate' ).addClass( 'd-none' );
  $( '#wai-recoder-clip-upload' ).removeClass( 'd-none' );
  let ipfsInfo = [];
  for (let index in ipfs){
    console.log('uploadIPFSInfo::index=<',index,'>');
    let result = ipfs[index];
    console.log('uploadIPFSInfo::result=<',result,'>');
    let params = result.path.split('@');
    let info = {
      phoneme:params[0],
      lang:params[1],
      ipfs:result.hash
    }
    ipfsInfo.push(info);
  }
  $( '#wai-recoder-clip-ipfs' ).val( JSON.stringify(ipfsInfo));
  $( '#wai-recoder-clip-ipfs-submit' ).click();
  clearUpLocalClips(ipfs);
}
function clearUpLocalClips(ipfs) {
  for (let index in ipfs){
    let result = ipfs[index];
    let params = result.path.split('@');
    console.log('clearUpLocalClips::params=<',params,'>');
    let key = 'wai/train/audio/clip/' + params[1] + '/' + params[0];
    console.log('clearUpLocalClips::key=<',key,'>');
    localStorage.removeItem(key);
  }
}
function bufferToBase64(buf) {
    let binstr = Array.prototype.map.call(buf, function (ch) {
        return String.fromCharCode(ch);
    }).join('');
    return btoa(binstr);
}
function base64ToBuffer(base64) {
    let binstr = atob(base64);
    let buf = new Uint8Array(binstr.length);
    Array.prototype.forEach.call(binstr, function (ch, i) {
      buf[i] = ch.charCodeAt(0);
    });
    return buf;
}
$(document).ready(function(){
  let counter = 0;
  for (let key in localStorage){
    if(key.startsWith('wai/train/audio/clip/')){
      counter += 1;
    }
  }
  console.log('document.ready::counter=<',counter,'>');
  $( '#wai-recoder-clip-in-local' ).text(counter + '@local');
});
</script>
