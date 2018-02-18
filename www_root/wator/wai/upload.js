function uploadSlice(data,phoneme) {
  var formData = new FormData();
  formData.append('filename', phoneme + '.webm');
  formData.append('data', data);
  var url = window.location.href;
  $.ajax({
    type : 'post',
    url : url,
    data : formData,
    contentType: false
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
