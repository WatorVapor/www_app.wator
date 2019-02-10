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
    var url = '/secauth/language';
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
        console.log('data=<',data,'>');
        sessionStorage.setItem('operation.lang.run',JSON.stringify(data));
        location.reload(true);
      },
      error : function(data) {
        // Error
        console.log(data);
        sessionStorage.setItem('operation.lang.run.error',JSON.stringify(data));
      }
    });
  }
}

