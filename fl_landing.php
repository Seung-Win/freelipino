<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  session_destroy();
  header('Location: index.html');
  exit;
}
if (isset($_POST['logout'])) {
  session_destroy();
  header('Location: index.html');
  exit;
}

if (!isset($_GET['page_no'])) {
  $page_no = 1;
} else {
  $page_no = $_GET['page_no'];
}


require 'config.php';

// Total rows or records to display
$total_records_per_pages = 3;

// Get the page offset for the LIMIT query
$offset = ($page_no - 1) * $total_records_per_page;

// Get previous page
$previous_page = $page_no - 1;

// Get the next page
$next_page = $page_no + 1;

// Get the total count of records
$result_count = mysqli_query($conn, "SELECT COUNT(*) as total_records FROM user_jobs WHERE freelancer_id = '" . $_SESSION['user_id'] . "'") or die(mysqli_error($conn));

// Total records
$records = mysqli_fetch_array($result_count);

// Store total_records to a variable
$total_records = $records['total_records'];

// Get total pages
$total_no_of_pages = ceil($total_records / $total_records_per_page);

// Query string if and elseif
$sql = "SELECT * FROM user_jobs WHERE freelancer_id ='" . $_SESSION['user_id'] . "'";

$sql .= " LIMIT $offset , $total_records_per_page";

// Result
$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Freelipino</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="assets/img/logo/logo.png">

  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
  <link rel="stylesheet" href="assets/css/flaticon.css">
  <link rel="stylesheet" href="assets/css/price_rangs.css">
  <link rel="stylesheet" href="assets/css/slicknav.css">
  <link rel="stylesheet" href="assets/css/animate.min.css">
  <link rel="stylesheet" href="assets/css/nice-select.css">
  <link rel="stylesheet" href="assets/css/magnific-popup.css">
  <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
  <link rel="stylesheet" href="assets/css/themify-icons.css">
  <link rel="stylesheet" href="assets/css/slick.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/pagination.css">
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />

  <style>
    .logo {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .logo img {
      max-width: 100%;
      height: auto;
    }

    .main-content {
      padding: 20px;
    }

    .container {
      max-width: 900px;
      margin: 0 auto;
    }

    h2 {
      margin-bottom: 20px;
    }

    .btn-primary {
      background-color: #007bff;
      border-color: #007bff;
    }

    .btn-primary:hover {
      background-color: #0069d9;
      border-color: #0062cc;
    }

    .btn-warning {
      background-color: #ffc107;
      border-color: #ffc107;
    }

    .btn-warning:hover {
      background-color: #e0a800;
      border-color: #d39e00;
    }

    .btn-danger {
      background-color: #dc3545;
      border-color: #dc3545;
    }

    .btn-danger:hover {
      background-color: #c82333;
      border-color: #bd2130;
    }

    /* Job list */
    .job-card {
      background-color: #fff;
      border: 1px solid #ddd;
      border-radius: 5px;
      transition: box-shadow 0.3s;
      margin-bottom: 20px;
      /* Add some spacing between job cards */
    }

    .job-card:hover {
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .job-card .card-body {
      padding: 20px;
    }

    .job-card h5 {
      font-size: 20px;
      margin-bottom: 10px;
    }

    .job-card p {
      color: #6c757d;
      margin-bottom: 15px;
    }

    .job-card .btn-group {
      margin-top: 15px;
    }

    /* Uniform job images */
    .job-card .job_img {
      width: 100%;
      height: 200px;
      /* Adjust the height as needed */
      object-fit: cover;
      /* Ensures the image covers the entire area without distortion */
      border-radius: 5px;
      /* Matches the border-radius of the card */
      margin-bottom: 15px;
      /* Spacing between image and text */
    }

    /* Modal backdrop */
    .modal-backdrop {
      background-color: rgba(0, 0, 0, 0.5);
    }

    /* Modal dialog */
    .modal-dialog {
      max-width: 600px;
      margin: 1.75rem auto;
    }

    /* Modal content */
    .modal-content {
      border-radius: 8px;
      border: none;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
    }

    /* Modal header */
    /* General Modal Styles */
    .modal-dialog {
      max-width: 600px;
      margin: 1.75rem auto;
    }

    .modal-content {
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
      background-color: #007bff;
      color: #fff;
      border-bottom: none;
      padding: 1rem 1.5rem;
      border-top-left-radius: 8px;
      border-top-right-radius: 8px;
    }

    .modal-title {
      margin: 0;
      font-size: 1.5rem;
    }

    .close {
      color: #fff;
      opacity: 0.8;
    }

    .close:hover,
    .close:focus {
      color: #fff;
      opacity: 1;
    }

    .modal-body {
      padding: 1rem;
    }

    .form-group label {
      font-weight: 600;
    }

    .form-control:focus {
      border-color: #80bdff;
      box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .modal-footer {

      border-top: none;
      border-bottom-left-radius: 8px;
      border-bottom-right-radius: 8px;
    }

    .btn-primary {
      background-color: #007bff;
      border-color: #007bff;
      border-radius: 4px;
    }

    .btn-primary:hover {
      background-color: #0056b3;
      border-color: #004085;
    }

    .btn-secondary {
      border-radius: 4px;
    }

    .alert-warning {
      border-radius: 4px;
    }

    .form-group select {
      width: 100%;
      padding: 8px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;
      background-color: #fff;
      background-repeat: no-repeat;
      background-position: right 10px center;
      background-size: 10px;
    }
  </style>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
  <div id="preloader-active">
    <div class="preloader d-flex align-items-center justify-content-center">
      <div class="preloader-inner position-relative">
        <div class="preloader-circle"></div>
        <div class="preloader-img pere-text">
          <img src="assets/img/logo/logo.png" alt="">
        </div>
      </div>
    </div>
  </div>
  <header>
    <div class="header-area header-transparrent">
      <div class="headder-top header-sticky">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-3 col-md-2">
              <div class="logo">
                <a href="fl_landing.php"><img src="assets/img/logo/logo.png" alt=""></a>
              </div>
            </div>
            <div class="col-lg-9 col-md-9">
              <div class="menu-wrapper">
                <div class="main-menu">
                  <nav class="d-none d-lg-block">
                    <ul id="navigation">
                      <li><a href="fl_landing.php">Jobs</a></li>
                      <li><a href="transaction.php">Transactions</a></li>
                    </ul>
                  </nav>
                </div>

                <?php
                if (isset($_SESSION['email'])) {
                  echo '<a href="profile.php" style="color: black;">Welcome <span style="color: rgb(16, 16, 16);">' . $_SESSION["first_name"] . '</span>!</a>';
                  echo '
                                        <form method="post" style="display: inline;">
                                            <button type="submit" name="logout" class="btn head-btn2">Logout</button>
                                        </form>';
                } else {
                  echo '
                                        <div class="header-btn d-none f-right d-lg-block">
                                            <a href="register.php" class="btn head-btn1">Register</a>
                                            <a href="login.php" class="btn head-btn2">Login</a>
                                        </div>';
                }
                ?>


              </div>
            </div>

            <div class="col-12">
              <div class="mobile_menu d-block d-lg-none"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </header>

  <main>
    <div class="container mt-5">
      <h2>Manage Jobs</h2>
      <button class="btn btn-primary" data-toggle="modal" data-target="#createJobModal">Create Job</button>

      <div class="mt-4" id="job_container">

        <?php
        if (mysqli_num_rows($result) > 0) {

          foreach ($result as $row) {
        ?>
            <div class="card mb-3 job-card">
              <div class="card-body">
                <h5 class="card-title"><?= $row['job_name'] ?></h5>
                <p class="card-text"><?= $row['job_description'] ?></p>
                <img class="job_img" src="assets/uploads/<?= $row['job_photo'] ?>" alt="JobImage">
                <div class="btn-group">
                  <button type="button" class="edit_product_button btn btn-warning"
                    value="<?= $row['job_id']; ?>">Edit</button>
                  <button type="button" value="<?= $row['job_id']; ?>"
                    class="delete_product_button btn btn-danger">Delete</button>
                </div>
              </div>
            </div>
        <?php
          }
        }
        $conn->close();
        ?>
      </div>
      <?php

      echo "<nav class='pagination'>";
      echo "<ul class='ul-pagination'>";

      echo "<li><a class='page-link " . ($page_no <= 1 ? 'disabled' : '') . "' " . ($page_no > 1 ? 'href="?page_no=' . $previous_page . '"' : '') . ">Previous</a></li>";

      for ($i = 1; $i <= $total_no_of_pages; $i++) {
        echo "<li><a class='page-no' href='?page_no=" . $i . "' class='" . ($page_no == $i ? 'active' : '') . "'>" . $i . "</a></li>";
      }

      echo "<li><a class='page-link " . ($page_no >= $total_no_of_pages ? 'disabled' : '') . "' " . ($page_no < $total_no_of_pages ? 'href="?page_no=' . $next_page . '"' : '') . ">Next</a></li>";

      echo "</ul>";
      echo "</nav>";
      ?>

      <div class="modal fade" id="createJobModal" tabindex="-1" role="dialog" aria-labelledby="createJobModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="createJobModalLabel">Create Job</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="createJobForm">
              <div class="modal-body">
                <div id="errorMessage" class="alert alert-warning d-none"></div>
                <div class="form-group">
                  <label for="jobTitle">Job Title</label>
                  <input type="text" class="form-control" id="jobTitle" name="jobTitle" required>
                </div>
                <div class="form-group">
                  <label for="jobDescription">Job Description</label>
                  <textarea class="form-control" id="jobDescription" name="jobDescription" rows="3" required></textarea>
                </div>
                <div class="form-group">
                  <label for="jobPrice">Job Price</label>
                  <input type="text" class="form-control" id="jobPrice" name="jobPrice" required>
                </div>
                <div class="form-group">
                  <label for="jobDuration">Job Duration</label>
                  <input type="text" class="form-control" id="jobDuration" name="jobDuration" required>
                </div>
                <div class="form-group">
                  <label for="jobCategory">Job Category</label>
                  <select class="form-control" id="jobCategory" name="jobCategory" required>
                    <option value="">Select Job Type</option>
                    <option value="Technology">Technology</option>
                    <option value="Arts">Arts</option>
                    <option value="Information Technology">IT</option>
                    <option value="Music">Music</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="jobPhoto">Job Photo</label>
                  <input type="file" class="form-control-file" id="jobPhoto" name="jobPhoto">
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Create Job</button>
              </div>



          </div>

          </form>
        </div>
      </div>
    </div>


    <div class="modal fade" id="editJobModal" tabindex="-1" role="dialog" aria-labelledby="editJobModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editJobModalLabel">Edit Job</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="editJobForm">
            <div class="modal-body">

              <div id="errorMessageUpdate" class="alert alert-warning d-none"></div>

              <input type="hidden" name="job_id" id="job_id">

              <div class="form-group">
                <label for="editJobTitle">Job Title</label>
                <input type="text" class="form-control" id="job_title" name="jobTitle" required>
              </div>
              <div class="form-group">
                <label for="editJobDescription">Job Description</label>
                <textarea class="form-control" id="job_description" name="jobDescription" rows="3" required></textarea>
              </div>
              <div class="form-group">
                <label for="editJobPrice">Job Price</label>
                <input type="text" class="form-control" id="job_price" name="jobPrice" required>
              </div>
              <div class="form-group">
                <label for="editJobDuration">Job Duration</label>
                <input type="text" class="form-control" id="job_duration" name="jobDuration" required>
              </div>
              <div>
                <p> </p>
              </div>
              <div class="form-group">
                <label for="job_Category">Job Category</label>
                <select class="form-control" id="job_category" name="job_Category" required>
                  <option value="">Select Job Type</option>
                  <option value="Technology">Technology</option>
                  <option value="Arts">Arts</option>
                  <option value="Information Technology">IT</option>
                  <option value="Music">Music</option>
                </select>
              </div>
              <div>
                <p> </p>
              </div>
              <div class="form-group">
                <p> </p>
                <label for="editJobDuration">Job Image</label>
                <input type="file" class="form-control-file" id="job_photo" name="jobPhoto" required>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
              </div>
            </div>

        </div>
      </div>
      </form>
    </div>
    </div>
    </div>

    </div>
    </div>
    </div>
  </main>

  <div class="apply-process-area apply-bg pt-150 pb-150" data-background="assets/img/gallery/how-applybg.png">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-tittle white-text text-center">
            <span>FREELIPINO PROCESS</span>
            <h2> How it works</h2>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-4 col-md-6">
          <div class="single-process text-center mb-30">
            <div class="process-ion">
              <span class="flaticon-search"></span>
            </div>
            <div class="process-cap">
              <h5>1. Search for freelancers</h5>
              <p>Find a suitable freelancers.</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="single-process text-center mb-30">
            <div class="process-ion">
              <span class="flaticon-curriculum-vitae"></span>
            </div>
            <div class="process-cap">
              <h5>2. Connect</h5>
              <p>You can interact with you preferred freelancers for discussions.</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="single-process text-center mb-30">
            <div class="process-ion">
              <span class="flaticon-tour"></span>
            </div>
            <div class="process-cap">
              <h5>3. Let the Job done</h5>
              <p>Rest assured that our freelancers will get the job done at your own timeline.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  </main>
  <footer>


    <div class="footer-bottom-area footer-bg">
      <div class="container">
        <div class="footer-border">
          <div class="row d-flex justify-content-between align-items-center">
            <div class="col-xl-10 col-lg-10 ">
              <div class="footer-copy-right">
                <p>All rights reserved 2024</p>
              </div>
            </div>
            <div class="col-xl-2 col-lg-2">
              <div class="footer-social f-right">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fas fa-globe"></i></a>
                <a href="#"><i class="fab fa-behance"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <!-- All JS Custom Plugins Link Here here -->
  <script src="./assets/js/vendor/modernizr-3.5.0.min.js"></script>
  <!-- Jquery, Popper, Bootstrap -->
  <script src="./assets/js/vendor/jquery-1.12.4.min.js"></script>
  <script src="./assets/js/popper.min.js"></script>
  <script src="./assets/js/bootstrap.min.js"></script>
  <!-- Jquery Mobile Menu -->
  <script src="./assets/js/jquery.slicknav.min.js"></script>

  <!-- Jquery Slick , Owl-Carousel Plugins -->
  <script src="./assets/js/owl.carousel.min.js"></script>
  <script src="./assets/js/slick.min.js"></script>
  <script src="./assets/js/price_rangs.js"></script>

  <!-- One Page, Animated-HeadLin -->
  <script src="./assets/js/wow.min.js"></script>
  <script src="./assets/js/animated.headline.js"></script>
  <script src="./assets/js/jquery.magnific-popup.js"></script>

  <!-- Scrollup, nice-select, sticky -->
  <script src="./assets/js/jquery.scrollUp.min.js"></script>
  <script src="./assets/js/jquery.nice-select.min.js"></script>
  <script src="./assets/js/jquery.sticky.js"></script>

  <!-- contact js -->
  <script src="./assets/js/contact.js"></script>
  <script src="./assets/js/jquery.form.js"></script>
  <script src="./assets/js/jquery.validate.min.js"></script>
  <script src="./assets/js/mail-script.js"></script>
  <script src="./assets/js/jquery.ajaxchimp.min.js"></script>

  <!-- Jquery Plugins, main Jquery -->
  <script src="./assets/js/plugins.js"></script>
  <script src="./assets/js/main.js"></script>
  <script scr="script.js"></script>

  <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
  <script src="ajax/crude_jobs.js"></script>

</body>

</html>