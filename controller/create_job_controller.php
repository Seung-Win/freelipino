<?php
require_once '../config.php';
session_start();

$response = [
  'status' => 0,
  'message' => 'Form submission failed'
];

try {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $job_title = mysqli_real_escape_string($conn, $_POST['jobTitle']);
    $job_description = mysqli_real_escape_string($conn, $_POST['jobDescription']);
    $job_price = mysqli_real_escape_string($conn, $_POST['jobPrice']);
    $job_duration = mysqli_real_escape_string($conn, $_POST['jobDuration']);
    $freelancer_id =  $_SESSION['user_id'];

    if (empty($job_title) || empty($job_description) || empty($job_price) || empty($job_duration)) {
      throw new Exception("Please fill up the whole form.");
    }

    if ($job_price < 0) {
      throw new Exception("Must be greater than 0");
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
      throw new Exception("Invalid Image Extension");
    }

    // Check if the file size is within limits
    if ($fileSize > 10000000000) {
      throw new Exception("Image Size is too large");
    }

    // Generate a unique filename
    $newImageName = uniqid() . '.' . $imageExtension;

    // Move the uploaded file to the destination directory
    if (move_uploaded_file($tmpName, '../assets/uploads/' . $newImageName)) {

      $insert_query = "INSERT INTO user_jobs (freelancer_id, job_name, job_description, job_price, job_duration, job_photo)
                     VALUES (?, ?, ?, ?, ?, ?)";
      $statement_insert = mysqli_prepare($conn, $insert_query);
      mysqli_stmt_bind_param($statement_insert, "ississ", $_SESSION['user_id'], $job_title, $job_description, $job_price, $job_duration, $newImageName);

      if (mysqli_stmt_execute($statement_insert)) {
        $response['message'] = "Thank you for adding jobs";
        $response['status'] = 1;

      } else {
        throw new Exception("Error in adding job");
      }

      mysqli_stmt_close($statement_insert);
    }

  }
}
} catch (Exception $e) {
  $response['message'] = $e->getMessage();
}

echo json_encode($response);
?>