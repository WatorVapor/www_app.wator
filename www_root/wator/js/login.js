var RSAAuth_ = RSAAuth_ || {};
RSAAuth_.isLoginRun_ = function() {
  let run = sessionStorage.getItem('auth.rsa.run');
  console.log('run=<',run,'>');
  if (run) {
    return true;
  } else {
    return false;
  }
}

RSAAuth_.login_ = function() {

}

$(document).ready(function(){
  let run = RSAAuth.isLoginRun_();
  console.log('run=<',run,'>');
  if(!run) {
    RSAAuth.login_();
  }
});
