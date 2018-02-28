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
    localStorage.setItem('/wai/train/audio/clip/' + phoneme,file);
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
  if(ipfs) {
    const files = [
      {
        path: phoneme + '1.webm',
        content: bufText
      },
      {
        path: phoneme + '2.webm',
        content: bufText
      }
    ];
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
