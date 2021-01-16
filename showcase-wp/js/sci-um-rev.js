jQuery(document).ready(function ($) {
  // $('#test').on('click', function (e) {
  //   e.preventDefault();
  //   console.log('clicked');
  //   $('.modal-body').text('Email sent!');
  //   $('#exampleModal').modal('show');
  // });

  $('#sci-rve').on('click', function (e) {
    e.preventDefault();
    console.log('Resending verification email...', userEmail);

    $.ajax({
      type: 'POST',
      url: UM_RAF.ajax_url,
      data: {
        action: 'um_raf_submit',
        // email: $("#um-raf-email").val(),
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
          //$("#um-raf-success").text(data.message).fadeIn();
          //$("#um-raf-email").val("");
          $('.modal-body').text(data.message);
          modal.call($('#revModal'));
        } else if (data.message) {
          //$("#um-raf-error").text(data.message).fadeIn();
          $('.modal-body').text(data.message);
          modal.call($('#revModal'));
          console.log(data.message);
        } else {
          // $("#um-raf-error")
          // 	.text("Something went wrong. Please contact support.")
          // 	.fadeIn();
          console.log('Something went wrong. Please contact support.');
          $('.modal-body').text(
            'Something went wrong. Please contact support.'
          );
          modal.call($('#revModal'));
        }
      },
      error: function (data) {
        // $("#um-raf-error")
        // 	.text("Something went wrong. Please contact support.")
        // 	.fadeIn();
        console.log('Something went wrong 2. Please contact support.');
      },
      complete: function () {
        //form.find("input, button").prop("disabled", false);
      },
    });
  });
});
