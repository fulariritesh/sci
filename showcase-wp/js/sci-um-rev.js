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
          $('#sci-rve').text('send email again');

          $('#resEmailVerification').empty();
				  $('#resEmailVerification').prepend('<div class="alert alert-success alert-dismissible"> \
															<button type="button" class="close" data-dismiss="alert">&times;</button> \
															'+data.message+'\
														</div>');

        } else if (data.message) {
          $('#sci-rve').text('send email again');

          $('#resEmailVerification').empty();
				  $('#resEmailVerification').prepend('<div class="alert alert-warning alert-dismissible"> \
															<button type="button" class="close" data-dismiss="alert">&times;</button> \
															'+data.message+'\
														</div>');

          console.log(data.message);
        } else {
          console.log('Something went wrong. Please contact support.');
          $('#sci-rve').text('send email again');

          $('#resEmailVerification').empty();
				  $('#resEmailVerification').prepend('<div class="alert alert-warning alert-dismissible"> \
															<button type="button" class="close" data-dismiss="alert">&times;</button> \
															'+data.message+'\
														</div>');

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
