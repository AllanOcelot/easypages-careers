jQuery(document).ready(function( $ ) {

  //Upload a file functions (As we use fancy buttons and not inputs ;)
  $('#cover_upload').click(function(){
    alert('test');
    $('#cover_upload_input').trigger('click');
  });


  // Get the form.
  var form = $('#job_application_form');

  // Get the messages div.
  var formMessages = $('#form-messages');

  // Set up an event listener for the contact form.
  $(form).submit(function(event) {
      // Stop the browser from submitting the form.
      event.preventDefault();
      var formData = $(form).serialize();
      alert(formData);

      $.ajax({
          type: 'POST',
          url: $(form).attr('action'),
          data: formData
      }).done(function(response) {
        // Make sure that the formMessages div has the 'success' class.
        $(formMessages).removeClass('error');
        $(formMessages).addClass('success');

        // Set the message text.
        $(formMessages).text(response);

        // Clear the form.
        $('#name').val('');
        $('#email').val('');
        $('#message').val('');
    }).fail(function(data) {
        // Make sure that the formMessages div has the 'error' class.
        $(formMessages).removeClass('success');
        $(formMessages).addClass('error');

        // Set the message text.
        if (data.responseText !== '') {
            $(formMessages).text(data.responseText);
        } else {
            $(formMessages).text('Oops! An error occured and your message could not be sent.');
        }
    });

  });
});
