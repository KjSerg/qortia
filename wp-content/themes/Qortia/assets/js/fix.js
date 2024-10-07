
$('.up_file').each(function () {
  $(this).prepend('<svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" style="enable-background:new 0 0 23.5 32" viewBox="0 0 23.5 32"><path d="M0 2.9V29c0 .8.3 1.5.9 2.1.5.6 1.3.9 2 .9h17.6c.8 0 1.5-.3 2.1-.9.6-.6.9-1.3.9-2.1V8.9c0-.1 0-.2-.1-.3 0-.1-.1-.2-.2-.2L15 .2c0-.1 0-.1-.1-.1-.1-.1-.2-.1-.3-.1H2.9C2.2 0 1.4.3.9.9c-.6.5-.9 1.3-.9 2zm20.9 5.3h-4c-.5 0-.9-.2-1.3-.5-.3-.3-.5-.8-.5-1.3v-4l5.8 5.8z" style="fill-rule:evenodd;clip-rule:evenodd;fill:#050912"></path></svg>')
})

$('.input_st[type="hidden"]').each(function () {
  $(this).closest('.form-group').addClass('hiden')
})

$(document).on('click', '.language-active', function () {
  $('.language').toggleClass('active');
});

$(document).on('click', function (e) {
  if (!$(e.target).closest('.language-active, .language-drop').length) {
    $('.language').removeClass('active');
  }


  e.stopPropagation();
});

$('a[href="#"]').click(function (e) {
  e.preventDefault();
});