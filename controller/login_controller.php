<?php
require '../config.php';

$response = [
  'status' => 0,
  'message' => 'Form submission failed'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
  $password = htmlspecialchars($_POST["password"]);
  $type = htmlspecialchars($_POST["userType"]);

  if (empty($email) || empty($password)) {
    $response['message'] = "Please provide both email and password";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response['message'] = "Invalid email format";
  } else {
    $check_existing = "SELECT user_id, user_first_name, user_middle_name, user_last_name, user_address, user_password, user_type
                      FROM user_account
                      WHERE user_email = ? AND user_type = ?";
    $statement = mysqli_prepare($conn, $check_existing);
    mysqli_stmt_bind_param($statement, "ss", $email, $type);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);

    if (mysqli_stmt_num_rows($statement) > 0) {
      mysqli_stmt_bind_result($statement, $user_id, $first_name, $middle_name, $last_name, $address, $hashed_password, $user_type);
      mysqli_stmt_fetch($statement);

      if (password_verify($password, $hashed_password)) {
        session_start();
        $_SESSION["user"] = "yes";
        $_SESSION["user_id"] = $user_id;
        $_SESSION["email"] = $email;
        $_SESSION["first_name"] = $first_name;
        $_SESSION["middle_name"] = $middle_name;
        $_SESSION["last_name"] = $last_name;
        $_SESSION["address"] = $address;
        $_SESSION["type"] = $user_type;

        if ($user_type == "CL") {
          $response['status'] = 1;
        } elseif ($user_type == "FL") {
          $response['status'] = 2;
        }
        $response['message'] = "Login successful";
      } else {
        $response['message'] = "Password does not match";
      }
    } else {
      $response['message'] = "Email does not exist";
    }

    mysqli_stmt_close($statement);
  }
}

echo json_encode($response);

$conn->close();
?>