<?php
header('Content-Type: application/json');
require_once '../config.php';

if (isset($_POST['proof'])) {
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
  
        // Prepare the update statement
        $query = "UPDATE transactions 
        SET transaction_end=curdate(), fl_proof=? 
        WHERE transaction_id=?";
        $statement = mysqli_prepare($conn, $query);
        
        // Bind parameters
        mysqli_stmt_bind_param($statement, "si",$newImageName, $transaction_id);
  
        // Execute the statement
        $query_run = mysqli_stmt_execute($statement);
        if ($query_run) {
        $res = [
        'status' => 200,
        'message' => 'Transaction Updated Successfully'
        ];
        echo json_encode($res);
        return;
        } else {
        $res = [
        'status' => 500,
        'message' => 'Transaction Not Updated'
        ];
        echo json_encode($res);
        return;
        }
      } 
    }
  }
?>