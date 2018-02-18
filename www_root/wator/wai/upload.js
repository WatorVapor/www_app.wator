
function uploadSlice(chunks,phoneme) {
  let blob = new Blob(chunks, {type:"application/octet-stream"});
  console.log('uploadSlice:blob=<',blob,'>');
  let formData = new FormData();
  formData.append('filename', phoneme + '.webm');
  formData.append('audio', blob);
  console.log('uploadSlice:formData=<',formData,'>');
  var url = window.location.href;
  $.ajax({
    type : 'post',
    url : url,
    data : formData,
    cache : false,
    contentType: false,
    processData: false,
    success : function(data) {
      // Success
      console.log(data);
    },
    error : function(data) {
      // Error
      console.log(data);
    }
  });
}


/*
const Buffer = window.IpfsApi().Buffer;

let ipfs = window.IpfsApi({host:'www.wator.xyz', port:'443', protocol: 'https'});
ipfs.id(function (err, identity) {
  if (err) {
    throw err
  }
  console.log('ipfs.id:identity=<',identity,'>');
});



function uploadSlice(chunks,phoneme) {
  const blob = new Blob(chunks, { type: 'audio/webm' });
  let bufText = Buffer.from(chunks, 'binary');
  if(ipfs) {
    ipfs.files.add(bufText,function(err, result){
      if (err) {
        throw err;
      }
      console.log('uploadSlice::result=<',result,'>');
    });
  }
}
*/

function saveToFile(chunks,phoneme) {
  const blob = new Blob(chunks, { type: 'audio/webm' });
  let urlBlob = window.URL.createObjectURL(blob);
  console.log('saveToFile:urlBlob=<',urlBlob,'>');
  let a = document.createElement('a');
  document.body.appendChild(a);
  a.style = 'display: none';
  a.href = urlBlob;
  a.download = phoneme + '.test.webm';
  a.click();
  window.URL.revokeObjectURL(urlBlob);
}

