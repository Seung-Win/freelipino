<?php
require_once '../config.php';
session_start();
date_default_timezone_set('Asia/Manila');

if (isset($_POST['hire_job'])) {
  $transaction_id = mysqli_real_escape_string($conn, $_POST['transaction_id']);

  // Check if the image file is uploaded successfully
  if (isset($_FILES["proof"]) && $_FILES["proof"]["error"] === UPLOAD_ERR_OK) {
    $fileName = $_FILES["proof"]["name"];
    $fileSize = $_FILES["proof"]["size"];
    $tmpName = $_FILES["proof"]["tmp_name"];

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
    if ($fileSize > 10000000) { // Adjusted to 10MB limit
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
      // Update the transaction details in the database
      $query_run = "UPDATE transactions 
                              SET transaction_end = NOW(), fl_proof = ? 
                              WHERE transaction_id = ?";
      $statement_run = mysqli_prepare($conn, $query_run);
      mysqli_stmt_bind_param($statement_run, "si", $newImageName, $transaction_id);


      if (mysqli_stmt_execute($statement_run)) {
        $res = [
          'status' => 200,
          'message' => 'Thank you for adding proof of job completion'
        ];
        echo json_encode($res);
        exit;
      } else {
        $res = [
          'status' => 500,
          'message' => 'Error in updating transaction: ' . mysqli_error($conn)
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
} else {
  $res = [
    'status' => 400,
    'message' => 'Invalid request'
  ];
  echo json_encode($res);
  exit;
  $conn->close();
}
?>