function uploadSlice(data) {
  var url = window.location.href;
  $.ajax({
    type : 'post',
    url : url,
    data : JSON.stringify(JSONdata),
    contentType: 'application/JSON',
    dataType : 'JSON',
    scriptCharset: 'utf-8',
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
