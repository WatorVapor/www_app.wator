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

function onClickDoneBtn(elem) {
  console.log('onClickDoneBtn:elem=<',elem,'>');
  $( '#wai-recoder-clip-done' ).addClass( 'd-none' );
  $( '#wai-recoder-clip-animate' ).removeClass( 'd-none' );
  uploadSliceToLocal(gClipChunks,'{{ $phoneme }}');
  //uploadInfo('none');
}

//let globalClipFiles = [];

function uploadSliceToLocal(chunks,phoneme) {
  const blob = new Blob(chunks, { type: 'audio/webm' });
  const reader = new FileReader();  
  reader.addEventListener('loadend', (e) => {
    const buffer = e.srcElement.result;
    let bufText = Buffer.from(buffer);
    let file = {
      path: phoneme,
      content: bufText
    }
    console.log('uploadSliceToLocal:file=<',file,'>');
    localStorage.setItem('wai/train/audio/clip/' + phoneme,bufferToBase64(bufText));
    $( '#wai-recoder-clip-animate' ).addClass( 'd-none' );
    uploadLocalToIpfs();
  }); 
  reader.readAsArrayBuffer(blob);
}

function uploadInfo(ipfs) {
  console.log('uploadInfo::ipfs=<',ipfs,'>');
  $( '#wai-recoder-clip-animate' ).addClass( 'd-none' );
  $( '#wai-recoder-clip-upload' ).removeClass( 'd-none' );
  $( '#wai-recoder-clip-upload-ipfs' ).val( ipfs[0].hash );
  const blob = new Blob(gClipChunks, { type: 'audio/webm' });
  let urlBlob = window.URL.createObjectURL(blob);
  $( '#wai-recoder-clip-upload-blob' ).val( urlBlob );
}


function uploadLocalToIpfs() {
  let files = [];
  for (let key in localStorage){
    if(key.startsWith('wai/train/audio/clip/')){
      console.log('uploadLocalToIpfs::key=<',key,'>');
      let bufStorage = localStorage.getItem(key);
      let bufText = Buffer.from(base64ToBuffer(bufStorage));
      
/*      
      ipfs.files.add(bufText,function(err, result){
        if (err) {
          throw err;
        }
        console.log('uploadSliceToIpfs::result=<',result,'>');
      });
      return;
*/      
      let file = {
        path: key,
        content: bufText
      };
      files.push(file);
    }
  }
  console.log('uploadLocalToIpfs::files=<',files,'>');
  if(ipfs) {
    ipfs.files.add(files,function(err, result){
      if (err) {
        throw err;
      }
      console.log('uploadSliceToIpfs::result=<',result,'>');
      setTimeout(function () { 
        uploadInfo(result);
      },1);
    });
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


/*
let workerSaveIPFS = new Worker('/wator/wai/saveIPFS.js');
workerSaveIPFS.onmessage = function(e) {
  console.log('workerSaveIPFS.onmessage::e=<',e,'>');
}
workerSaveIPFS.onerror = function(e) {
  console.log('workerSaveIPFS.onmessage::e=<',e,'>');
}
console.log('::workerSaveIPFS=<',workerSaveIPFS,'>');
workerSaveIPFS.postMessage(ipfs);
*/

</script>
