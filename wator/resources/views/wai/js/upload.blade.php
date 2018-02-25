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

function uploadSliceToIpfs(chunks,phoneme) {
  const blob = new Blob(chunks, { type: 'audio/webm' });
  const reader = new FileReader();  
  reader.addEventListener('loadend', (e) => {
    const buffer = e.srcElement.result;
    let bufText = Buffer.from(buffer);
    if(ipfs) {
      ipfs.files.add(bufText,function(err, result){
        if (err) {
          throw err;
        }
        console.log('uploadSliceToIpfs::result=<',result,'>');
        setTimeout(function () { 
          uploadInfo(result);
        },1);
      });
    }
  }); 
  reader.readAsArrayBuffer(blob);
}

function uploadInfo(ipfs) {
    $( '#wai-recoder-clip-operator' ).removeClass( 'd-none' );
}
</script>
