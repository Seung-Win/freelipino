<?php
require_once '../config.php';
session_start();

if (isset($_POST['save_job'])) {
  $job_title = mysqli_real_escape_string($conn, $_POST['jobTitle']);
  $job_description = mysqli_real_escape_string($conn, $_POST['jobDescription']);
  $job_price = mysqli_real_escape_string($conn, $_POST['jobPrice']);
  $job_duration = mysqli_real_escape_string($conn, $_POST['jobDuration']);
  $job_category = mysqli_real_escape_string($conn, $_POST['jobCategory']);
  $freelancer_id = $_SESSION['user_id'];

  // Check if all fields are filled
  if (empty($job_title) || empty($job_description) || empty($job_price) || empty($job_duration) || empty($job_category)) {
    $res = [
      'status' => 422,
      'message' => 'All fields are mandatory'
    ];
    echo json_encode($res);
    exit;
  }

  if ($job_price < 0) {
    $res = [
      'status' => 422,
      'message' => 'Price must be greater than 0'
    ];
    echo json_encode($res);
    exit;
  }

  // Check if the image file is uploaded successfully
  if (isset($_FILES["jobPhoto"]) && $_FILES["jobPhoto"]["error"] === UPLOAD_ERR_OK) {
    $fileName = $_FILES["jobPhoto"]["name"];
    $fileSize = $_FILES["jobPhoto"]["size"];
    $tmpName = $_FILES["jobPhoto"]["tmp_name"];

    $validImageExtensions = ['jpg', 'jpeg', 'png'];
    $imageExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Check if the file extension is valid
    if (!in_array($imageExtension, $validImageExtensions)) {
      $res = [
        'status' => 422,
        'message' => 'Invalid Image Extension'
      ];
      echo json_encode($res);
      exit;
    }

    // Check if the file size is within limits
    if ($fileSize > 10000000000) { // 10GB is a very large file size limit, consider reducing it
      $res = [
        'status' => 422,
        'message' => 'Image Size is too large'
      ];
      echo json_encode($res);
      exit;
    }

    // Generate a unique filename
    $newImageName = uniqid() . '.' . $imageExtension;

    // Move the uploaded file to the destination directory
    if (move_uploaded_file($tmpName, '../assets/uploads/' . $newImageName)) {
      // Insert product details into the database
      $insert_query = "INSERT INTO user_jobs (freelancer_id, job_name, job_description, job_price, job_duration, job_photo, job_category)
                             VALUES (?, ?, ?, ?, ?, ?, ?)";
      $statement_insert = mysqli_prepare($conn, $insert_query);
      mysqli_stmt_bind_param($statement_insert, "ississ", $freelancer_id, $job_title, $job_description, $job_price, $job_duration, $newImageName, $job_category);

      if (mysqli_stmt_execute($statement_insert)) {
        $res = [
          'status' => 200,
          'message' => 'Thank you for adding jobs'
        ];
        echo json_encode($res);
        exit;
      } else {
        $res = [
          'status' => 500,
          'message' => 'Error in adding job: ' . mysqli_error($conn)
        ];
        echo json_encode($res);
        exit;
      }
    } else {
      // Failed to move the uploaded file
      $res = [
        'status' => 500,
        'message' => 'Failed to move the uploaded file'
      ];
      echo json_encode($res);
      exit;
    }
  } else {
    // Image file upload failed
    $res = [
      'status' => 422,
      'message' => 'Image upload failed'
    ];
    echo json_encode($res);
    exit;
  }
}


// edit first part
if (isset($_GET['job_id'])) {
  $job_id = mysqli_real_escape_string($conn, $_GET['job_id']);

  $query = "SELECT * FROM user_jobs WHERE job_id = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "s", $job_id);
  mysqli_stmt_execute($stmt);
  $query_run = mysqli_stmt_get_result($stmt);

  if (mysqli_num_rows($query_run) == 1) {
    $job = mysqli_fetch_array($query_run);

    $res = [
      'status' => 200,
      'message' => 'Job Fetch Successfully by id',
      'data' => $job
    ];
    echo json_encode($res);
    return;
  } else {
    $res = [
      'status' => 404,
      'message' => 'Job id Not Found'
    ];
    echo json_encode($res);
    return;
  }
}

// edit second part
if (isset($_POST['update_job'])) {
  $job_id = mysqli_real_escape_string($conn, $_POST['job_id']);
  $job_title = mysqli_real_escape_string($conn, $_POST['jobTitle']);
  $job_description = mysqli_real_escape_string($conn, $_POST['jobDescription']);
  $job_price = mysqli_real_escape_string($conn, $_POST['jobPrice']);
  $job_duration = mysqli_real_escape_string($conn, $_POST['jobDuration']);

  // Check if the image file is uploaded successfully
  if (isset($_FILES["jobPhoto"]) && $_FILES["jobPhoto"]["error"] === UPLOAD_ERR_OK) {
    $fileName = $_FILES["jobPhoto"]["name"];
    $fileSize = $_FILES["jobPhoto"]["size"];
    $tmpName = $_FILES["jobPhoto"]["tmp_name"];

    $validImageExtensions = ['jpg', 'jpeg', 'png'];
    $imageExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Check if the file extension is valid
    if (!in_array($imageExtension, $validImageExtensions)) {
      $res = [
        'status' => 422,
        'message' => 'Invalid Image Extension'
      ];
      echo json_encode($res);
      exit;
    }

    // Check if the file size is within limits
    if ($fileSize > 10000000000) { // 10GB is a very large file size limit, consider reducing it
      $res = [
        'status' => 422,
        'message' => 'Image Size is too large'
      ];
      echo json_encode($res);
      exit;
    }

    // Retrieve the image filename associated with the job
    $query = "SELECT job_photo FROM user_jobs WHERE job_id = ?";
    $statement = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($statement, "i", $job_id);
    mysqli_stmt_execute($statement);
    mysqli_stmt_bind_result($statement, $current_image);
    mysqli_stmt_fetch($statement);
    mysqli_stmt_close($statement);

    if ($current_image) {
        // Delete the image file
        $image_path = 'assets/uploads/' . $current_image;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }

    // Generate a unique filename
    $newImageName = uniqid() . '.' . $imageExtension;

    // Move the uploaded file to the destination directory
    if (move_uploaded_file($tmpName, '../assets/uploads/' . $newImageName)) {

      // Prepare the update statement
      $query = "UPDATE user_jobs 
      SET job_name=?, job_description=?, job_price=?, job_duration=?, job_photo=?
      WHERE job_id=?";
      $statement = mysqli_prepare($conn, $query);

      // Bind parameters
      mysqli_stmt_bind_param($statement, "ssissi", $job_title, $job_description, $job_price, $job_duration, $job_photo, $job_id);

      // Execute the statement
      $query_run = mysqli_stmt_execute($statement);
      if ($query_run) {
      $res = [
      'status' => 200,
      'message' => 'Job Updated Successfully'
      ];
      echo json_encode($res);
      return;
      } else {
      $res = [
      'status' => 500,
      'message' => 'Jtudent Not Updated'
      ];
      echo json_encode($res);
      return;
      }
    } 
  }
}

// delete job
if (isset($_POST['delete_job'])) {
  $job_id = mysqli_real_escape_string($conn, $_POST['job_id']);

  // Retrieve the image filename associated with the job
  $query = "SELECT job_photo FROM user_jobs WHERE job_id = ?";
  $statement = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($statement, "i", $job_id);
  mysqli_stmt_execute($statement);
  mysqli_stmt_bind_result($statement, $job_photo);
  mysqli_stmt_fetch($statement);
  mysqli_stmt_close($statement);

  if ($job_photo) {
      // Delete the image file
      $image_path = 'assets/uploads/' . $job_photo;
      if (file_exists($image_path)) {
          unlink($image_path);
      }
  }

  // Delete the job record
  $query = "DELETE FROM user_jobs WHERE job_id = ?";
  $statement = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($statement, "s", $job_id);
  mysqli_stmt_execute($statement);

  if (mysqli_stmt_affected_rows($statement) > 0) {
      $res = [
          'status' => 200,
          'message' => 'Job Deleted Successfully'
      ];
  } else {
      $res = [
          'status' => 500,
          'message' => 'Job Not Deleted'
      ];
  }

  mysqli_stmt_close($statement);
  echo json_encode($res);
}

