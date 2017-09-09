$(function () {
  $('.language_button').click(function(){
    let lang = this.value;
    console.log('lang=<' + lang + '>');
    if(lang) {
      localStorage.setItem('operation.lang',lang);
    }
    //window.location.href = window.location.href;
  });
});

function updateLanguage() {
  var lang = localStorage.getItem('operation.lang')
  if(lang && typeof lang === 'string') {
    var url = '/account/language';
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
      },
      error : function(data) {
        // Error
        console.log(data);
      }
    });
  }
}

