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
  var url = '/rsaauth/login/auto';
  $.ajax({
    type : 'get',
    url : url,
    scriptCharset: 'utf-8',
    success : function(data) {
      // Success
      console.log(data);
      sessionStorage.setItem('auth.rsa.run',data);
      location.reload(true);
    },
    error : function(data) {
      // Error
      console.log(data);
    }
  });
}

$(document).ready(function(){
  let run = RSAAuth_.isLoginRun_();
  console.log('run=<',run,'>');
  if(!run) {
    RSAAuth.login_();
  }
});
