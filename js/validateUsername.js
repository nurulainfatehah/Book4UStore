$('document').ready(function(){
 var username_state = false;
 var email_state = false;
 $('#username').on('blur', function(){
  var username = $('#username').val();
  if (username == '') {
    username_state = false;
    alert("Username shall not have any whitespaces. Please try again");
    $('#submit').prop('disabled', true);
    $('#reset').prop('disabled', true);
    $('#submit').css({ 'color': 'white', 'background-color': 'gray' });
    $('#reset').css({ 'color': 'white', 'background-color': 'gray' });
    return;
    
  }else if (/\s/.test(username)) {
    username_state = false;
    alert("Username shall not have any whitespaces. Please try again");
    $('#submit').prop('disabled', true);
    $('#reset').prop('disabled', true);
    $('#submit').css({ 'color': 'white', 'background-color': 'gray' });
    $('#reset').css({ 'color': 'white', 'background-color': 'gray' });
    return;
  }
  $.ajax({
    url: 'signUp.php',
    type: 'post',
    data: {
      'username_check' : 1,
      'username' : username,
    },
    success: function(response){
      if (response == 'taken' ) {
        username_state = false;
        alert("Sorry, the username entered is taken. Please use another username.");
        $('#submit').prop('disabled', true);
        $('#reset').prop('disabled', true);
        $('#submit').css({ 'color': 'white', 'background-color': 'gray', 'cursor': 'default'  });
        $('#reset').css({ 'color': 'white', 'background-color': 'gray', 'cursor': 'default'  });
      }else if (response == 'not_taken') {
        username_state = true;
        $('#submit').prop('disabled', false);
        $('#reset').prop('disabled', false);
        $('#submit').css({ 'color': 'black', 'background-color': 'pink', 'cursor': 'pointer'  });
        $('#reset').css({ 'color': 'black', 'background-color': 'pink', 'cursor': 'pointer'  });
        $("#submit").mouseenter(function() {
          $(this).css("background-color", "#ff0072").css("color", "white");
        }).mouseleave(function() {
         $(this).css("background-color", "pink").css("color", "black");
       });
        $("#reset").mouseenter(function() {
            $(this).css("background-color", "#ff0072").css("color", "white");
          }).mouseleave(function() {
           $(this).css("background-color", "pink").css("color", "black");
         });
      }
    }
  });
 });    



  $('#email').on('blur', function(){
  var email = $('#email').val();
  if (email == '') {
    email_state = false;
    alert("Username shall not have any whitespaces. Please try again");
    $('#submit').prop('disabled', true);
    $('#reset').prop('disabled', true);
    $('#submit').css({ 'color': 'white', 'background-color': 'gray' });
    $('#reset').css({ 'color': 'white', 'background-color': 'gray' });
    return;
  }else if (/\s/.test(email)) {
    email_state = false;
    alert("E-mail shall not have any whitespaces. Please try again");
    $('#submit').prop('disabled', true);
    $('#reset').prop('disabled', true);
    $('#submit').css({ 'color': 'white', 'background-color': 'gray', 'cursor': 'default'  });
    $('#reset').css({ 'color': 'white', 'background-color': 'gray', 'cursor': 'default'  });
    return;
  }
  $.ajax({
      url: 'signUp.php',
      type: 'post',
      data: {
        'email_check' : 1,
        'email' : email,
      },
      success: function(response){
        if (response == 'taken' ) {
         /* email_state = false;
          alert("Sorry, the email entered is taken. If you think this is a mistake, do proceed to sign in and click forget password.");
          $('#submit').prop('disabled', true);
          $('#reset').prop('disabled', true);
          $('#submit').css({ 'color': 'white', 'background-color': 'gray', 'cursor': 'default'  });
          $('#reset').css({ 'color': 'white', 'background-color': 'gray', 'cursor': 'default' });*/
        }else if (response == 'not_taken') {
          email_state = true;
          $('#submit').prop('disabled', false);
          $('#reset').prop('disabled', false);
          $('#submit').css({ 'color': 'black', 'background-color': 'pink', 'cursor': 'pointer'  });
          $('#reset').css({ 'color': 'black', 'background-color': 'pink', 'cursor': 'pointer'  });
          $("#submit").mouseenter(function() {
            $(this).css("background-color", "#ff0072").css("color", "white");
          }).mouseleave(function() {
           $(this).css("background-color", "pink").css("color", "black");
         });
          $("#reset").mouseenter(function() {
            $(this).css("background-color", "#ff0072").css("color", "white");
          }).mouseleave(function() {
           $(this).css("background-color", "pink").css("color", "black");
         });


        }
      }
  });
 });
});