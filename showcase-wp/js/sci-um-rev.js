jQuery(document).ready(function ($) {
  $('#sci-rve').on('click', function (e) {
    e.preventDefault();
    console.log('Resending verification email...', userEmail);
    $('#sci-rve').text('resending verification email...');
    $.ajax({
      type: 'POST',
      url: UM_RAF.ajax_url,
      data: {
        action: 'um_raf_submit',
        email: userEmail,
        nonce: UM_RAF.nonce,
        recaptcha_input:
          typeof grecaptcha != 'undefined' && grecaptcha.getResponse()
            ? grecaptcha.getResponse()
            : '',
      },
      dataType: 'json',
      success: function (data) {
        if (data.success && data.message) {
          $('.modal-body').text(data.message);
          $('#sci-rve').text('send email again');
          modal.call($('#revModal'));
        } else if (data.message) {
          $('.modal-body').text(data.message);
          $('#sci-rve').text('send email again');
          modal.call($('#revModal'));
          console.log(data.message);
        } else {
          console.log('Something went wrong. Please contact support.');
          $('#sci-rve').text('send email again');
          $('.modal-body').text(
            'Something went wrong. Please contact support.'
          );
          modal.call($('#revModal'));
        }
      },
      error: function (data) {
        $('#sci-rve').text('send email again');
        console.log('Something went wrong 2. Please contact support.');
      },
      complete: function () {
        //form.find("input, button").prop("disabled", false);
      },
    });
  });
});
