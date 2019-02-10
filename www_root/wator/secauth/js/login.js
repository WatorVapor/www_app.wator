$(document).ready(function(){
  let privateKey = SecAuth.getPriKey();
  if(!privateKey) {
    return;
  }
  let token = SecAuth.getToken();
  console.log('token=<',token,'>');
  if(!token) {
    return;
  }
  let elemToken = document.getElementById("sec.login.accessToken");
  console.log('elemToken=<',elemToken,'>');
  if(elemToken) {
    elemToken.value = token;
    console.log('elemToken.value=<',elemToken.value,'>');
  }
  let lang = localStorage.getItem('operation.lang');
  let elemLang = document.getElementById("sec.login.lang");
  console.log('elemLang=<',elemLang,'>');
  if(elemLang) {
    elemLang.value = lang;
    console.log('elemLang.value=<',elemLang.value,'>');
  }
  
  const jwkPrv = JSON.parse(privateKey);
  if(!jwkPrv) {
    return;
  }
  console.log('jwkPrv=<',jwkPrv,'>');
  let prvKey = KEYUTIL.getKey(jwkPrv);
  console.log('prvKey=<',prvKey,'>');
  let elemAccess = document.getElementById("sec.login.access");
  if(elemAccess) {
    let access = elemAccess.value;
    let ecSign = new KJUR.crypto.ECDSA({'curve': 'secp256r1'});
    let signEngine = new KJUR.crypto.Signature({alg: 'SHA256withECDSA'});
    signEngine.init({d: prvKey.prvKeyHex, curve: 'secp256r1'});
    signEngine.updateString(access);
    let signatureHex = signEngine.sign();
    console.log('signatureHex=<',signatureHex,'>');
    let elemSign = document.getElementById("sec.login.signature");
    if(elemSign) {
      elemSign.value = signatureHex;
      let elemAuto = document.getElementById("sec.login.auto");
      if(elemAuto) {
        if(elemAuto.textContent.trim() === 'true') {
          doAutoLogin();
        }
      }
    }
  }
});
function doAutoLogin() {
  document.forms['secauth_login_form'].submit();
}
