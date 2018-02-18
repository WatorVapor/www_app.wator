
function uploadSlice(audio,phoneme) {
  console.log('uploadSlice:audio=<',audio,'>');
  let formData = new FormData();
  formData.append('filename', phoneme + '.webm');
  formData.append('audio', audio);
  console.log('uploadSlice:formData=<',formData,'>');
  var url = window.location.href;
  $.ajax({
    type : 'post',
    url : url,
    data : formData,
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


function saveToFile(url,phoneme) {
  let a = document.createElement('a');
  document.body.appendChild(a);
  a.style = 'display: none';
  a.href = url;
  a.download = phoneme + '.test.webm';
  a.click();
  window.URL.revokeObjectURL(url);
}

