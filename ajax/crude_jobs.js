// add jobs
$(document).on('submit', '#createJobForm', function(e) {
  e.preventDefault();

  let formData = new FormData(this);
  formData.append("save_job", true);

  $.ajax({
    type: "POST",
    url: "/freelipino/controller/crude_job_controller.php",
    data: formData,
    processData: false,
    contentType: false,
    success: function(response) {

      let res = jQuery.parseJSON(response);
      if (res.status == 422) {
        $('#errorMessage').removeClass('d-none');
        $('#errorMessage').text(res.message);

      } else if (res.status == 200) {

        $('#errorMessage').addClass('d-none');
        $('#createJobModal').modal('hide');
        $('#createJobForm')[0].reset();

        alertify.set('notifier', 'position', 'top-right');
        alertify.success(res.message);

        $('#job_container').load(location.href + " #job_container");

      } else if (res.status == 500) {
        alert(res.message);
      }
    }
  });
});

// to show the value of old
$(document).on('click', '.edit_product_button', function() {
  let job_id = $(this).val();

  $.ajax({
    type: "GET",
    url: "/freelipino/controller/crude_job_controller.php?job_id=" + job_id,
    success: function(response) {
      console.log(response);

      let res = JSON.parse(response);
      if (res.status == 404) {
        alert(res.message);
      } else if (res.status == 200) {
        $('#job_id').val(res.data.job_id);
        $('#job_title').val(res.data.job_name);
        $('#job_description').val(res.data.job_description);
        $('#job_price').val(res.data.job_price);
        $('#job_duration').val(res.data.job_duration);

        // Debugging logs
        console.log("Job Category from AJAX:", res.data.job_category);
        console.log("Dropdown before setting value:", $('#job_category').val());

        // Ensure the correct category is selected
        $('#job_category').val(res.data.job_category).trigger('change');

        // Debugging logs
        console.log("Dropdown after setting value:", $('#job_category').val());
        console.log("All dropdown options:", $('#job_category option').map(function() { return $(this).val(); }).get());

        $('#job_category option').each(function() {
          console.log("Option value:", $(this).val(), "Selected:", $(this).is(':selected'));
        });

        $('#editJobModal').modal('show');
      }
    }
  });
});




// to update the edited job
$(document).on('submit', '#editJobForm', function(e) {
  e.preventDefault();

  let formData = new FormData(this);
  formData.append("update_job", true);

  $.ajax({
    type:"POST",
    url: "/freelipino/controller/crude_job_controller.php",
    data: formData,
    processData: false,
    contentType: false,
    success: function(response) {

      let res = JSON.parse(response);
      if (res.status == 422) {
        $('#errorMessageUpdate').removeClass('d-none');
        $('#errorMessageUpdate').text(res.message);
      } else if (res.status == 200) {
        $('#errorMessageUpdate').addClass('d-none');

        alertify.set('notifier', 'position', 'top-right');
        alertify.success(res.message);

        $('#editJobModal').modal('hide');
        $('#editJobForm')[0].reset();

        $('#job_container').load(location.href + " #job_container");

      } else if (res.status == 500) {
        alert(res.message);
      }
    }
  })
})

// delete data for job
$(document).on('click', '.delete_product_button', function(e) {
  e.preventDefault();

  if (confirm('Are you sure you want to delete this data?')) {
    let job_id = $(this).val();
    $.ajax({
      type: "POST",
      url: "/freelipino/controller/crude_job_controller.php",
      data: {
        'delete_job': true,
        'job_id': job_id
      },
      success: function(response) {

        let res = jQuery.parseJSON(response);
        if (res.status == 500) {

          alert(res.message);
        } else {
          alertify.set('notifier', 'position', 'top-right');
          alertify.success(res.message);

          $('#job_container').load(location.href + " #job_container");
        }
      }
    });
  }
});