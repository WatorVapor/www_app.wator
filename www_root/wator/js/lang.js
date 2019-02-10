function onClickLanguage(lang) {
  console.log('lang=<' + lang + '>');
  if(lang) {
    localStorage.setItem('operation.lang',lang);
    updateLanguage();
  }
}
function updateLanguage() {
  let lang = localStorage.getItem('operation.lang')
  if(lang && typeof lang === 'string') {
    let elemLang = document.getElementById("nav.sec.login.lang");
    console.log('elemLang=<',elemLang,'>');
    if(elemLang) {
      elemLang.value = lang;
      console.log('elemLang.value=<',elemLang.value,'>');
    }
    document.forms['secauth_navi_lang_form'].submit();

/*    
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
*/
  }
}

