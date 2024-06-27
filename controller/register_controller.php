<?php
require 'config.php';

$response = [
  'status' => 0,
  'message' => 'Form submission failed'
];

try {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $first_name = htmlspecialchars($_POST["fname"]);
    $middle_name = htmlspecialchars($_POST["mname"]);
    $last_name = htmlspecialchars($_POST["lname"]);
    $address = htmlspecialchars($_POST["address"]);
    $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    $password = htmlspecialchars($_POST["password"]);

    if (empty($first_name) || empty($middle_name) || empty($last_name) || empty($address) || empty($email) || empty($password)) {
      throw new Exception("Please fill up the whole form.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      throw new Exception("Email is not valid");
    }

    if (empty($password)) {
      throw new Exception("Fill up the password");
    }

    if (strlen($password) < 8) {
      throw new Exception("Password must be at least 8 characters long");
    }

    $check_existing = "SELECT *
                       FROM user_account
                       WHERE user_email = ?";
    $statement = mysqli_prepare($conn, $check_existing);
    mysqli_stmt_bind_param($statement, "s", $email);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);

    if (mysqli_stmt_num_rows($statement) > 0) {
      throw new Exception("Sorry! Email already exists");
    }

    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $insert_query = "INSERT INTO user_account (user_first_name, user_middle_name, user_last_name, user_address, user_email, user_password)
                     VALUES (?, ?, ?, ?, ?, ?)";
    $statement_insert = mysqli_prepare($conn, $insert_query);
    mysqli_stmt_bind_param($statement_insert, "ssssss", $first_name, $middle_name, $last_name, $address, $email, $password_hash);

    if (mysqli_stmt_execute($statement_insert)) {
      $response['message'] = "Thank you for registering";
      $response['status'] = 1;
    } else {
      throw new Exception("Error in registration");
    }

    mysqli_stmt_close($statement_insert);
    mysqli_stmt_close($statement);
  }
} catch (Exception $e) {
  $response['message'] = $e->getMessage();
}

echo json_encode($response);
