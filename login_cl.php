<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
  <div class="background-logo">
    <a href="index.html">
      <img src="assets/img/logo/logo.png" alt="Logo">
    </a>
  </div>
  <div class="container">
    <h2>Login as Client</h2>
    <form action="#" method="POST" id="loginForm">
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
      </div>
      <div class="form-group">
        <input type="hidden" id="userType"  name="userType" value="CL">
        <button type="submit">Login</button>
      </div>
    </form>
    <div class="form-group">
      <a href="login.php"><button>Login as Freelancer</button></a>
    </div>
    <p id="errorMessage" class="error-message"></p>
  </div>
  <script src="script.js"></script>
  <script src="ajax/ajax_register_login.js"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      login();
    });
  </script>
</body>

</html>