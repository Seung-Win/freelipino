
function create() {

  $("#createJobForm").on('submit', function(e) {
    e.preventDefault();

    const form_data = new FormData(this);

    $.ajax({
      type: "POST",
      url: "/freelipino/controller/create_job_controller.php",
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
          $("#createJobForm")[0].reset(); // resets the form
          window.location.href = 'fl_landing.php';
        } else {
          correct_message.css("display", "none");
          error_message.css("display", "block");
          error_message.html(`<p>${response.message}</p>`);
        }
      }
    })
  })
}