$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


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


RSAAuth.isLoginRun_ = function() {
  let run = sessionStorage.getItem('auth.rsa.run');
  console.log('run=<',run,'>');
  if (run) {
    return true;
  } else {
    return false;
  }
}


RSAAuth.getAccess_ = function() {
  let access = sessionStorage.getItem('auth.rsa.access') || RSAAuth.uniAccess_();
  return access;
}

RSAAuth.reLogin_ = function() {
  RSAAuth.login();
}

RSAAuth.uniAccess_ = function() {
  let JSONdata ={};
  let url = '/rsaauth/access';
  $.ajax({
    type : 'post',
    url : url,
    success : function(data) {
      // Success
      console.log(data);
      //window.location.href = '/';
      sessionStorage.setItem('auth.rsa.access',data);
      // reload in
      setTimeout(RSAAuth.reLogin_,0);
    },
    error : function(e) {
      console.error(e);
      window.location.href = '/rsaauth/error';
    }
  });
}

RSAAuth.signLogin_ = function(privateKey,token,access) {
  let rsaKey = KEYUTIL.getKeyFromPlainPrivatePKCS8PEM(privateKey);
  //console.log(rsaKey);
  let signature = rsaKey.sign(access,"sha256");
  //console.log(signature);
  let JSONdata ={};
  JSONdata.accessToken = token;
  JSONdata.access = access;
  JSONdata.signature = signature;
  let url = '/rsaauth/login';
  $.ajax({
    type : 'post',
    url : url,
    data : JSON.stringify(JSONdata),
    contentType: 'application/JSON',
    dataType : 'JSON',
    scriptCharset: 'utf-8',
    success : function(data) {
      // Success
      console.log('data=<',data,'>');
      sessionStorage.setItem('auth.rsa.run',JSON.stringify(data));
      window.location.href = window.location.href;
    },
    error : function(data) {
      // Error
      console.log('data=<',data,'>');
      sessionStorage.setItem('auth.rsa.run',JSON.stringify(data));
      window.location.href = '/rsaauth/error';
    }
  });
}

RSAAuth.clear = function() {
  let JSONdata ={};
  let url = '/rsaauth/login';
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
      sessionStorage.setItem('auth.rsa.run',JSON.stringify(data));
      //window.location.href = '/';
    },
    error : function(data) {
      // Error
      console.log(data);
      sessionStorage.setItem('auth.rsa.run',JSON.stringify(data));
      window.location.href = '/rsaauth/error';
    }
  });
}

RSAAuth.login = function() {
  let privateKey = RSAAuth.getPriKey();
  let token = RSAAuth.getToken();
  let access = RSAAuth.getAccess_();
  if(!access) {
    console.warn('No access Key create it');
    return
  }
  //console.log(privateKey);
  if (privateKey && 'string'== typeof privateKey && token && 'string'== typeof token ) {
    RSAAuth.signLogin_(privateKey,token,access);
  } else {
    RSAAuth.clear();
  }
}

$(document).ready(function(){
  let run = RSAAuth.isLoginRun_();
  console.log('run=<',run,'>');
  if(!run) {
    RSAAuth.login();
  }
});
