<?php
require 'config.php';
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
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Freelipinosssss</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="assets/img/logo/logo.png">

  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
  <link rel="stylesheet" href="assets/css/flaticon.css">
  <link rel="stylesheet" href="assets/css/price_rangs.css">
  <link rel="stylesheet" href="assets/css/slicknav.css">
  <link rel="stylesheet" href="assets/css/animate.min.css">
  <link rel="stylesheet" href="assets/css/magnific-popup.css">
  <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
  <link rel="stylesheet" href="assets/css/themify-icons.css">
  <link rel="stylesheet" href="assets/css/slick.css">
  <link rel="stylesheet" href="assets/css/nice-select.css">
  <link rel="stylesheet" href="assets/css/style.css">

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

    main {
      padding: 60px 0;
      /* Adjust padding as needed */
    }

    .transaction-history {
      margin-bottom: 40px;
      /* Space between sections */
    }

    .transaction-history table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    .transaction-history th,
    .transaction-history td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }

    .transaction-history th {
      background-color: #f2f2f2;
    }

    .proof-img {
      max-width: 50px;
      cursor: pointer;
    }

    .total-counter {
      margin-top: 40px;
    }

    .total-earnings {
      text-align: center;
      padding: 20px;
      background-color: #f0f0f0;
      border: 1px solid #ccc;
      border-radius: 5px;
    }


    .modal {
      display: none;
      position: fixed;
      z-index: 1;
      padding-top: 60px;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgb(0, 0, 0);
      background-color: rgba(0, 0, 0, 0.9);
    }

    .modal-content {
      margin: auto;
      display: block;
      width: 80%;
      max-width: 700px;
    }

    .close {
      position: absolute;
      top: 15px;
      right: 35px;
      color: #fff;
      font-size: 40px;
      font-weight: bold;
      transition: 0.3s;
    }

    .close:hover,
    .close:focus {
      color: #bbb;
      text-decoration: none;
      cursor: pointer;
    }

    #caption {
      margin: auto;
      display: block;
      width: 80%;
      max-width: 700px;
      text-align: center;
      color: #ccc;
      padding: 10px 0;
      height: 150px;
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
  </header>

  <body>
    <main>
      <section class="transaction-history">
        <div class="container">
          <h2>Ongoing Transactions</h2>
          <table class="table">
            <thead>
              <tr>
                <th>Transaction ID</th>
                <th>Job Name</th>
                <th>Client ID</th>
                <th>Transaction Start</th>
                <th>Transaction End</th>
                <th>Job Value</th>
                <th>Comments</th>
                <th>Proof</th>
              </tr>
            </thead>
            <tbody>
              <?php

              $user_id = $_SESSION['user_id'];

              $query = "SELECT t.transaction_id, t.client_id, t.transaction_start, t.transaction_end, t.cl_comment,t.fl_proof, uj.job_name, uj.freelancer_id, uj.job_price
                                  FROM transactions t
                                  JOIN user_jobs uj ON t.job_id = uj.job_id
                                  WHERE uj.freelancer_id = '$user_id' AND transaction_end IS NULL;";

              $query_run = mysqli_query($conn, $query);

              if (mysqli_num_rows($query_run) > 0) {
                foreach ($query_run as $row) {

              ?>
                  <tr>
                    <td><?= $row['transaction_id'] ?></td>
                    <td><?= $row['job_name'] ?></td>
                    <td><?= $row['client_id']   ?></td>
                    <td><?= date('Y-m-d', strtotime($row['transaction_start'])) ?></td>
                    <td>Ongoing</td>
                    <td>₱ <?= $row['job_price'] ?></td>
                    <td><?= $row['cl_comment']   ?></td>
                    <td>
                      <form id="hireJob">
                        <input type="file" id="proof" name="proof" accept="image/*"
                          data-transaction-id="<?= $row['transaction_id'] ?>">
                        <button type="submit" class="btn">Upload</button>
                      </form>
                    </td>
                  </tr>
              <?php
                }
              } else {
                echo '<tr><td colspan="7">No ongoing transactions</td></tr>';
              }
              ?>
            </tbody>
          </table>
        </div>

        <div class="container">
          <h2>Finished Transactions</h2>
          <table class="table">
            <thead>
              <tr>
                <th>Transaction ID</th>
                <th>Job Name</th>
                <th>Client ID</th>
                <th>Transaction Start</th>
                <th>Transaction End</th>
                <th>Job Value</th>
                <th>Proof</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $query = "SELECT t.transaction_id, t.client_id, t.transaction_start, t.transaction_end, t.fl_proof, uj.job_name, uj.job_photo, uj.freelancer_id, uj.job_price
                            FROM transactions t
                            JOIN user_jobs uj ON t.job_id = uj.job_id
                            WHERE uj.freelancer_id = '$user_id' AND transaction_end IS NOT NULL;";

              $query_run = mysqli_query($conn, $query);

              if (mysqli_num_rows($query_run) > 0) {
                foreach ($query_run as $row) {
              ?>
                  <tr>
                    <td><?= $row['transaction_id'] ?></td>
                    <td><?= $row['job_name'] ?></td>
                    <td><?= $row['client_id']   ?></td>
                    <td><?= date('Y-m-d', strtotime($row['transaction_start'])) ?></td>
                    <td><?= date('Y-m-d', strtotime($row['transaction_end'])) ?></td>
                    <td>₱ <?= $row['job_price'] ?></td>
                    <td><a href="<?= ($row['fl_proof'] != NULL) ? "assets/uploads/" . $row['fl_proof'] : "" ?>"
                        style="color: blue;">Transaction Proof</a></td>

                  </tr>
              <?php
                }
              } else {
                echo '<tr><td colspan="7">No finished transactions</td></tr>';
              }
              ?>
            </tbody>
          </table>
        </div>
      </section>

      <section class="total-counter">
        <?php
        $query = "SELECT SUM(uj.job_price) as total_earnings
              FROM transactions t
              JOIN user_jobs uj ON t.job_id = uj.job_id
              WHERE uj.freelancer_id = '$user_id' AND t.transaction_end IS NOT NULL;";

        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
          $result = mysqli_fetch_assoc($query_run);
          $total_earnings = $result['total_earnings'];
        ?>
          <div class="container">
            <div id="total-earnings" class="total-earnings">
              <h3>Total Earnings: ₱<?= $total_earnings ?></h3>
            </div>
          </div>
        <?php
        } else {
          echo "No transactions found.";
        }
        $conn->close();
        ?>
      </section>


      <!-- Modal Structure -->
      <div id="imageModal" class="modal">
        <span class="close">&times;</span>
        <img class="modal-content" id="modalImg">
        <div id="caption"></div>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
      var modal = document.getElementById("imageModal");

      // Get the image and insert it inside the modal
      var modalImg = document.getElementById("modalImg");
      var captionText = document.getElementById("caption");

      document.querySelectorAll('.proof-img').forEach(img => {
        img.onclick = function() {
          modal.style.display = "block";
          modalImg.src = this.src;
          captionText.innerHTML = this.alt;
        }
      });

      // Get the <span> element that closes the modal
      var span = document.getElementsByClassName("close")[0];

      // When the user clicks on <span> (x), close the modal
      span.onclick = function() {
        modal.style.display = "none";
      }

      $(document).on('submit', '#hireJob', function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        formData.append("hire_job", true);

        // Get the file input
        let fileInput = document.getElementById('proof');
        let file = fileInput.files[0];

        // Get the transaction ID from the data attribute
        let transactionId = fileInput.getAttribute('data-transaction-id');

        // Append the file to the FormData object
        if (file) {
          formData.append('proof', file);
        }

        // Append the transaction ID to the FormData object
        formData.append('transaction_id', transactionId);

        $.ajax({
          type: "POST",
          url: "/freelipino/controller/upload_proof_controller.php",
          data: formData,
          processData: false,
          contentType: false,
          success: function(data) {
            location.reload()
          }
        });
      });
    </script>

  </body>

</html>