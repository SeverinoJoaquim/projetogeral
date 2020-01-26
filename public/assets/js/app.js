
/* Hide error messages - Ocultar mensagens de erro*/
$('#error-message').delay(2000).fadeOut('slow');

/* Generate random password - Gerar senha aleatória*/
$('#btn-password').click(
  function () {

    let chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@#$%&';
    let pass = '';
    let num_chars = 12;

    for (let i = 0; i < num_chars; i++) {
      pass += chars.charAt(Math.floor(Math.random() * chars.length));
    }

    $('input[name=text_password]').val(pass);
    $('input[name=text_password_repetir]').val(pass);

  }
);