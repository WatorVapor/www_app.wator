var RSAAuth = RSAAuth || {};
RSAAuth.LS_AUTH_KEY_PRV = 'wator.auth.ecdsa.key.private';
RSAAuth.LS_AUTH_KEY_PUB = 'wator.auth.ecdsa.key.public';
RSAAuth.LS_AUTH_KEY_TOKEN = 'wator.auth.ecdsa.key.token';
RSAAuth.getPubKey = function() {
  return localStorage.getItem(RSAAuth.LS_AUTH_KEY_PUB);
}
RSAAuth.getPriKey = function() {
  return localStorage.getItem(RSAAuth.LS_AUTH_KEY_PRV);
}
RSAAuth.getToken = function() {
  return localStorage.getItem(RSAAuth.LS_AUTH_KEY_TOKEN);
}


RSAAuth.upPubKey = function(cb) {
  var pubKey = RSAAuth.getPubKey();
  var token = RSAAuth.getToken();
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

