$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


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


RSAAuth.isLoginRun_ = function() {
  let autoElem = document.getElementById('rsa.login.session.auto');
  console.log('autoElem=<',autoElem,'>');
  if(autoElem) {
    console.log('autoElem.textContent=<',autoElem.textContent,'>');
    let flag = autoElem.textContent.replace(/ /g,'');
    if(flag === 'true') {
      return true;
    }
    console.log('autoElem.textContent=<',autoElem.textContent,'>');
  }
  return false;
}


RSAAuth.getAccess_ = function() {
  let accessElem = document.getElementById('rsa.login.session.access');
  if(accessElem) {
    return accessElem.textContent.replace(/ /g,'');
  }
  return '';
}



RSAAuth.signLogin_ = function(privateKey,token,access) {
  const jwkPrv = JSON.parse(privateKey);
  if(!jwkPrv) {
    return;
  }
  console.log('jwkPrv=<',jwkPrv,'>');
  let prvKey = KEYUTIL.getKey(jwkPrv);
  console.log('prvKey=<',prvKey,'>');
  let ecSign = new KJUR.crypto.ECDSA({'curve': 'secp256r1'});
  let signEngine = new KJUR.crypto.Signature({alg: 'SHA256withECDSA'});
  signEngine.init({d: prvKey.prvKeyHex, curve: 'secp256r1'});
  signEngine.updateString(access);
  let signatureHex = signEngine.sign();
  console.log('signatureHex=<',signatureHex,'>');
  
  let JSONdata ={};
  JSONdata.accessToken = token;
  JSONdata.access = access;
  JSONdata.signature = signatureHex;
  let url = '/secauth/login';
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
      location.reload(true);
    },
    error : function(data) {
      // Error
      console.log('data=<',data,'>');
      sessionStorage.setItem('auth.rsa.run.error',JSON.stringify(data));
      window.location.href = '/secauth/error';
    }
  });
}

RSAAuth.clear = function() {
  let JSONdata ={};
  let url = '/secauth/login';
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
      sessionStorage.setItem('auth.rsa.run.error',JSON.stringify(data));
      window.location.href = '/secauth/error';
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
  if(run) {
    RSAAuth.login();
  }
});
