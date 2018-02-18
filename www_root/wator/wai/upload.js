
function uploadSlice(chunks,phoneme) {
  console.log('uploadSlice:audio=<',audio,'>');
  let blob = new Blob(chunks, {type:"application/octet-stream"}
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
  window.URL.revokeObjectURL(url);
}

