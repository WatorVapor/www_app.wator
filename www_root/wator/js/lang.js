$(function () {
  $('.language_button').click(function(){
    let lang = this.value;
    console.log('lang=<' + lang + '>');
    if(lang) {
      localStorage.setItem('operation.lang',lang);
      updateLanguage();
    }
  });
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


function onClickLanguage(lang) {
  console.log('lang=<' + lang + '>');
  if(lang) {
    localStorage.setItem('operation.lang',lang);
    updateLanguage();
  }
}
function updateLanguage() {
  var lang = localStorage.getItem('operation.lang')
  if(lang && typeof lang === 'string') {
    var url = '/rsaauth/language';
    var JSONdata ={lang:lang};
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
        sessionStorage.setItem('operation.lang.run',data);
        location.reload(true);
      },
      error : function(data) {
        // Error
        console.log(data);
      }
    });
  }
}

/*
check language at boot.
*/
var run = sessionStorage.getItem('operation.lang.run')
if(! run) {
  updateLanguage();
}
