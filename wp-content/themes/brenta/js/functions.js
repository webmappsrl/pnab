jQuery(document).ready(function( $ ) {

  $('#brenta_login').submit( function(e) {
    e.preventDefault();
    $('#brenta_login').hide();
    $('#brenta_loader').css('display', 'block');

    var user = $('#user').val();
    var password = $('#password').val();

    var data = {
      'action': 'brenta_login_action',
      'user': user,
      'password': password
    }

    $.post(ajax_object.ajax_url, data, function (response) {
      $('#brenta_loader').css('display', 'none');
      $('#brenta_login').show();
      if( response === 'true'){
        location.reload();
      } else {
        alert(response)
      }

    })
  })

  $('form div.acf-hidden').each(function (i) {
    $('[id="' + this.id + '"]').slice(1).remove();
  });
  $('form input#acf-_validate_email').each(function (i) {
    $('[id="' + this.id + '"]').slice(1).remove();
  });


  if ( $('#impresa-update').length ){
    $('#acf-field_5a5890970d639').prop('readonly', true);
    $('#acf-field_5a5890970d639').attr('name', '');

  }
  
});