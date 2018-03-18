var RSAAuth = RSAAuth || {};
RSAAuth.upPubKey = function(cb) {
  var pubKey = localStorage.getItem('auth.rsa.key.public');
  var token = localStorage.getItem('auth.rsa.token');
  if (pubKey && token) {
    var JSONdata ={};
    JSONdata.token = token;
    JSONdata.pubKey = pubKey;
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
        if(typeof cb === 'function') {
          cb(data);
        }
      },
      error : function(data) {
        // Error
        console.log(data);
        if(typeof cb === 'function') {
          cb(data);
        }
      }
    });
  } else {
    // error.
  }
}

