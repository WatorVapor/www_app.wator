var RSAAuth = RSAAuth || {};

RSAAuth.getPubKey = function() {
  return localStorage.getItem('auth.rsa.key.public');
}
RSAAuth.getPriKey = function() {
  return localStorage.getItem('auth.rsa.key.private');
}
RSAAuth.getToken = function() {
  return localStorage.getItem('auth.rsa.token');
}

RSAAuth.sign = function(privateKey,token,payload) {
    var rsaKey = KEYUTIL.getKeyFromPlainPrivatePKCS8PEM(privateKey);
    //console.log(rsaKey);
    var signature = rsaKey.sign(token,"sha256");
    //console.log(signature);
    var JSONdata ={};
    JSONdata.token = token;
    JSONdata.sign = signature;
    JSONdata.payload = payload;
    var url = '/rsaauth/profile';
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


RSAAuth.profile = function(payload) {
  var privateKey = RSAAuth.getPriKey();
  var token = RSAAuth.getToken();
  //console.log(privateKey);
  if (privateKey && 'string'== typeof privateKey && token && 'string'== typeof token ) {
    RSAAuth.sign(privateKey,token,payload);
  }
}
