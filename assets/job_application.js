jQuery(document).ready(function( $ ) {

  //Declare the variables  we will be checking.
  $name_valid = false;
  $email_valid = false;
  $cover_valid = false;
  $cv_valid = false;

  //Function to check the file upload inputs, This function will be run to update the file variables.
  function checkInput(thisVar){
    if(thisVar.val() != null && thisVar.val() != ' ' && thisVar.val() != ''){
      return true;
    }else {
      return false;
    }
  }



  //Do a very basic check to make sure the user enters in a name and email
  $('#easyPages_fullName').change(function(){
    if(checkInput($(this))){
      $(this).removeClass('error');
      $(this).addClass('valid');
    }else{
      $(this).removeClass('valid');
      $(this).addClass('error')
    }
  });
  $('#easyPages_fullName').blur(function(){
    if(checkInput($(this))){
      $(this).removeClass('error');
      $(this).addClass('valid');
    }else{
      $(this).removeClass('valid');
      $(this).addClass('error')
    }
  });







  //Upload a file functions (As we use fancy buttons and not inputs ;)
  $('#cover_upload').click(function(){
    $('#cover_upload_input').trigger('click');
  });
    $('#cover_upload_input').change(function(){
      if(checkInput($(this))){
        $cover_valid = true;
        $('#cover_upload').addClass('input-good');
      }else{
        $cover_valid = false;
        $('#cover_upload').removeClass('input-good');
      }
    });

  //Upoad the users CV
  $('#CV_upload').click(function(){
    $('#CV_upload_input').trigger('click');
  });
    $('#CV_upload_input').change(function(){
      if(checkInput($(this))){
        $cv_valid = true;
        $('#CV_upload').addClass('input-good');
      }else{
        $cv_valid = false;
        $('#CV_upload').addClass('input-bad');
      }
    });

  // Get the form.
  var form = $('#job_application_form');

  // Get the messages div.
  var formMessages = $('#form-messages');


  //Let's just do a simple check to see if the user has actually given us good info
  if(
  $name_valid == true;
  $email_valid == true;
  $cover_valid == true;
  $cv_valid == true ){
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
  }else{

  }


});
