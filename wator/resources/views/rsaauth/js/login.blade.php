<script type="text/javascript">

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



$(document).ready(function(){
  let privateKey = RSAAuth.getPriKey();
  if(!privateKey) {
    return;
  }
  let token = RSAAuth.getToken();
  console.log('token=<',token,'>');
  if(!token) {
    return;
  }
  let elemToken = document.getElementById("rsa.login.accessToken");
  console.log('elemToken=<',elemToken,'>');
  if(elemToken) {
    elemToken.value = token;
    console.log('elemToken.value=<',elemToken.value,'>');
  }
  
  let rsaKey = KEYUTIL.getKeyFromPlainPrivatePKCS8PEM(privateKey);
  console.log('rsaKey=<',rsaKey,'>');
  let elemAccess = document.getElementById("rsa.login.access");
  if(elemAccess) {
    let access = elemAccess.value;
    let signature = rsaKey.sign(access,"sha256");
    console.log('access=<',access,'>');
    console.log('signature=<',signature,'>');
    let elemSign = document.getElementById("rsa.login.signature");
    if(elemSign) {
      elemSign.value = signature;
      let elemAuto = document.getElementById("rsa.login.auto");
      if(elemAuto) {
        if(elemAuto.value === 'true') {
          doAutoLogin();
        }
      }
    }
  }

});
function doAutoLogin() {
  document.forms['rsaauth_login_form'].submit();
}

</script>
