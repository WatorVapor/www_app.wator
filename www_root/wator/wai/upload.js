/*
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
*/


const Buffer = window.IpfsApi().Buffer;

let ipfs = window.IpfsApi({host:'www.wator.xyz', port:'443', protocol: 'https'});
ipfs.id(function (err, identity) {
  if (err) {
    throw err
  }
  console.log('ipfs.id:identity=<',identity,'>');
});

function uploadSlice(chunks,phoneme) {
  let bufText = Buffer.from(chunks, 'binary');
  if(ipfs) {
    ipfs.files.add(bufText,function(err, result){
      if (err) {
        throw err;
      }
      console.log('uploadSlice::result=<',result,'>');
      setTimeout(function () { 
        tryReadFromIpfs(result);
      },1);
    });
  }
}

function tryReadFromIpfs(result) {
  console.log('tryReadFromIpfs::result=<',result,'>');
  //const blob = new Blob(chunks, { type: 'audio/webm' });
}

ipfs.files.cat('QmS9JArPwa55ePgDnyg6TzX24mYTS1b1vLqWNebyVotKxQ',function(err, file){
  if (err) {
    throw err;
  }
  console.log('ipfs.files.cat::file=<',file,'>');
  let res = [];
  file.on('data', function (chunk) {
    console.log('chunk:', chunk)
    res.push(chunk);
  })
  file.on('error', function (err) {
    console.error('Oh nooo', err)    
  })
  file.on('end', function () {
    console.log('Got:', res)
    var blob = new Blob(res, { type: 'audio/webm' })
    console.log('ipfs.files.cat::blob=<',blob,'>');
  });
  file.read();
  
});




/*
function uploadSlice(chunks,phoneme) {
  console.log('uploadSlice:chunks=<',chunks,'>');
  const blob = new Blob(chunks, { type: 'audio/webm' });
  console.log('uploadSlice:blob=<',blob,'>');
  let urlBlob = window.URL.createObjectURL(blob);
  console.log('uploadSlice:urlBlob=<',urlBlob,'>');
  let pack = {blob:blob};
  const reader = new FileReader();
  
  reader.addEventListener('loadend', (e) => {
    const text = e.srcElement.result;
    console.log('uploadSlice:text=<',text,'>');
  }); 
  reader.readAsText(blob);
  
  console.log('uploadSlice:pack=<',pack,'>');
  console.log('uploadSlice:pack=<',JSON.stringify(pack),'>');
  let file = document.getElementById('upload-form-audio').files;
  console.log('uploadSlice:file=<',file,'>');
  window.URL.revokeObjectURL(urlBlob);
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

