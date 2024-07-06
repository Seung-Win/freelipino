<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Page</title>
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
    <h2>REGISTER</h2>
    <form id="registrationForm">
      <div class="form-group">
        <label for="fname">First Name:</label>
        <input type="text" id="fname" name="fname" required>
      </div>
      <div class="form-group">
        <label for="mname">Middle Name:</label>
        <input type="text" id="mname" name="mname" required>
      </div>
      <div class="form-group">
        <label for="lname">Last Name:</label>
        <input type="text" id="lname" name="lname" required>
      </div>
      <div class="form-group">
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
      </div>
      <div class="form-group">
        <label for="userType">Select Role:</label>
        <select id="userType" name="userType" required>
          <option value="" disabled selected>Select your role</option>
          <option value="CL">Client</option>
          <option value="FL">Freelancer</option>
        </select>
      </div>
      <div class="form-group">
        <button type="submit">Register</button>
      </div>
    </form>
    <div id="errorMessage" class="error-message"></div>
    <div id="correctMessage" class="correct-message"></div>
  </div>
  <script src="script.js"></script>
  <script src="ajax/ajax_register_login.js"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      register();
    });
  </script>
</body>

</html>