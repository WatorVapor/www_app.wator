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
  uploadSliceToLocal(gClipChunks,'{{ $phoneme }}');
  //uploadInfo('none');
}


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
    localStorage.setItem('wai/train/audio/clip/' + '{{ $lang }}/' + phoneme,bufferToBase64(bufText));
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
  for (let key in localStorage){
    if(key.startsWith('wai/train/audio/clip/')){
      console.log('uploadLocalToIpfs::key=<',key,'>');
      let bufStorage = localStorage.getItem(key);
      let bufText = Buffer.from(base64ToBuffer(bufStorage));
      let params = key.split('/');
      let phoneme = params[params.length -1];
      let lang = params[params.length -2];
      let file = {
        path:  phoneme + '@' + lang,
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
        uploadIPFSInfo(result);
      },1);
    });
  }
}

function uploadIPFSInfo(ipfs) {
  console.log('uploadIPFSInfo::ipfs=<',ipfs,'>');
  $( '#wai-recoder-clip-animate' ).addClass( 'd-none' );
  $( '#wai-recoder-clip-upload' ).removeClass( 'd-none' );
  $( '#wai-recoder-clip-ipfs' ).val( JSON.stringify(ipfs));
  $( '#wai-recoder-clip-ipfs-submit' ).click();
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
