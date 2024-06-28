
function register() {

  $("#registrationForm").on('submit', function(e) {
    e.preventDefault();

    const first_name = $('#fname').val();
    const middle_name = $('#mname').val();
    const last_name = $('#lname').val();
    const address = $('#address').val();
    const email = $('#email').val();
    const password = $('#password').val();

    const form_data = new FormData(this);

    $.ajax({
      type: "POST",
      url: "freelipino/controller/register_controller.php",
      data: form_data,
      dataType: "json",
      contentType: false,
      cache: false,
      processData: false,

      success: function(response) {
        const correct_message = $(".correct-message");
        const error_message = $(".error-message");

        if (response.status == 1) {
          error_message.css("display", "none");
          correct_message.css("display", "block");
          correct_message.html(`<p>${response.message}</p>`);
          $("#registrationForm")[0].reset(); // resets the form
        } else {
          correct_message.css("display", "none");
          error_message.css("display", "block");
          error_message.html(`<p>${response.message}</p>`);
        }
      }
    })
  })
}

// Login

function login() {

  $("#loginForm").on('submit', function(e) {
    e.preventDefault();

    const form_data = new FormData(this);

    $.ajax({
      type: "POST",
      url: "/freelipino-team/controller/login_controller.php",
      data: form_data,
      dataType: "json",
      contentType: false,
      cache: false,
      processData: false,

      success: function(response) {
        const correct_message = $(".correct-message");
        const error_message = $(".error-message");

        if (response.status == 1) {
          $("#loginForm")[0].reset(); // resets the form
            window.location.href = 'index.html';
        } else {
          correct_message.css("display", "none");
          error_message.css("display", "block");
          error_message.html(`<p>${response.message}</p>`);
        }
      }
    })
  })
}