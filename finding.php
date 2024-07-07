<?php
session_start();
?>

<!doctype html>
<html lang="eng">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Find Freelancer</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="manifest" href="site.webmanifest">
  <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">


  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
  <link rel="stylesheet" href="assets/css/price_rangs.css">
  <link rel="stylesheet" href="assets/css/flaticon.css">
  <link rel="stylesheet" href="assets/css/slicknav.css">
  <link rel="stylesheet" href="assets/css/animate.min.css">
  <link rel="stylesheet" href="assets/css/magnific-popup.css">
  <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
  <link rel="stylesheet" href="assets/css/themify-icons.css">
  <link rel="stylesheet" href="assets/css/slick.css">
  <link rel="stylesheet" href="assets/css/nice-select.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
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

/* Button styles */
button {
  background-color: white;
  border: 1px solid #3A4688;
  color: black;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 20px 2px;
  cursor: pointer;
  border-radius: 12px;
  transition-duration: 0.4s;
}

button:hover {
  background-color: #3A4688;
  color: white;
}

/* Modal styles */
.modal {
  display: none;
  /* Hidden by default */
  position: fixed;
  /* Stay in place */
  z-index: 1;
  /* Sit on top */
  left: 0;
  top: 0;
  width: 100%;
  /* Full width */
  height: 100%;
  /* Full height */
  overflow: auto;
  /* Enable scroll if needed */
  background-color: rgba(0, 0, 0, 0.4);
  /* Black with opacity */
}

.modal-content {
  background-color: #fefefe;
  margin: auto;
  /* Center modal horizontally and vertically */
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
  /* Adjust width as needed */
  max-width: 600px;
  /* Max width for responsiveness */
  position: relative;
  top: 50%;
  transform: translateY(-50%);
}

.close {
  color: #aaa;
  position: absolute;
  top: 0;
  right: 10px;
  font-size: 28px;
  font-weight: bold;
  cursor: pointer;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
}

/* Styles for the job item container */
.single-job-items {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px;
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 5px;
  margin-bottom: 30px;
  height: 150px;
  /* Set a fixed height */
}

/* Styles for the company image */
.company-img img {
  max-width: 100px;
  max-height: 100px;
  object-fit: cover;
  border-radius: 5px;
}

/* Styles for the job title container */
.job-tittle {
  flex-grow: 1;
  margin-left: 20px;
}

.job-tittle a h4 {
  font-size: 20px;
  margin: 0 0 10px 0;
}

/* Styles for the job details */
.job-tittle ul {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  align-items: center;
}

.job-tittle ul li {
  margin-right: 20px;
  font-size: 16px;
}

/* Styles for the job link */
.items-link {
  margin-left: auto;
}

.items-link a {
  padding: 10px 20px;
  background-color: #007bff;
  color: #fff;
  border-radius: 5px;
  text-decoration: none;
}

.items-link a:hover {
  background-color: #0056b3;
}
</style>

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
                <a href="cl_landing.php"><img src="assets/img/logo/logo.png" alt=""></a>
              </div>
            </div>
            <div class="col-lg-9 col-md-9">
              <div class="menu-wrapper">
                <div class="main-menu">
                  <nav class="d-none d-lg-block">
                    <ul id="navigation">
                      <li><a href="finding.php">Find Freelancer</a></li>
                      <li><a href="profile.php">Profile</a></li>
                      <li><a href="about.html">About</a></li>
                      <li><a href="contact.html">Contact</a></li>
                    </ul>
                  </nav>
                </div>
                <?php
                                require 'config.php';
                                if (isset($_POST['logout'])) {
                                    session_destroy();
                                    header('Location: index.html');
                                    exit;
                                }

                                if (isset($_SESSION['email'])) {
                                    echo 'Welcome ' . ($_SESSION["first_name"]) . ' !';
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

    <!-- Hero Area Start-->
    <div class="slider-area ">
      <div class="single-slider section-overly slider-height2 d-flex align-items-center"
        data-background="assets/img/hero/about.jpg">
        <div class="container">
          <div class="row">
            <div class="col-xl-12">
              <div class="hero-cap text-center">
                <h2>Get your job</h2>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Hero Area End -->
    <!-- Job List Area Start -->
    <div class="job-listing-area pt-120 pb-120">
      <div class="container">
        <div class="row">
          <!-- Left content -->
          <div class="col-xl-3 col-lg-3 col-md-4">
            <div class="row">
              <div class="col-12">
                <div class="small-section-tittle2 mb-45">
                  <div class="ion"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                      width="20px" height="12px">
                      <path fill-rule="evenodd" fill="rgb(27, 207, 107)"
                        d="M7.778,12.000 L12.222,12.000 L12.222,10.000 L7.778,10.000 L7.778,12.000 ZM-0.000,-0.000 L-0.000,2.000 L20.000,2.000 L20.000,-0.000 L-0.000,-0.000 ZM3.333,7.000 L16.667,7.000 L16.667,5.000 L3.333,5.000 L3.333,7.000 Z" />
                    </svg>
                  </div>
                  <h4>Filter Jobs</h4>
                </div>

                <button type="button" onclick="openModal()">
                  Add Jobs
                </button>

                <div id="myModal" class="modal">
                  <!-- Modal content -->
                  <div class="modal-content">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <h2>Job Details</h2>
                    <form id="registrationForm">
                      <div class="form-group">
                        <label for="fname">Position:</label>
                        <input type="text" id="position" name="position" required>
                      </div>
                      <div class="form-group">
                        <label for="mname">Qualifications:</label>
                        <input type="text" id="qualification" name="qualification" required>
                      </div>
                      <div class="form-group">
                        <label for="lname">Service Rate:</label>
                        <input type="text" id="rate" name="rate" required>
                      </div>
                      <div class="form-group">
                        <label for="address">Duration:</label>
                        <input type="text" id="duration" name="duration" required>
                      </div>
                      <div class="form-group">
                        <button type="submit">Submit</button>
                      </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Job Category Listing start -->
            <div class="job-category-listing mb-50">
              <!-- single one -->
              <div class="single-listing">
                <div class="small-section-tittle2">
                  <h4>Job Category</h4>
                </div>
                <!-- Select job items start -->
                <div class="select-job-items2">
                  <select name="select">
                    <option value="">All Category</option>
                    <option value="">Category 1</option>
                    <option value="">Category 2</option>
                    <option value="">Category 3</option>
                    <option value="">Category 4</option>
                  </select>
                </div>
                <!--  Select job items End-->
                <!-- select-Categories start -->
                <div class="select-Categories pt-80 pb-50">
                  <div class="small-section-tittle2">
                    <h4>Job Type</h4>
                  </div>
                  <label class="container">Full Time
                    <input type="checkbox">
                    <span class="checkmark"></span>
                  </label>
                  <label class="container">Part Time
                    <input type="checkbox" checked="checked active">
                    <span class="checkmark"></span>
                  </label>
                  <label class="container">Remote
                    <input type="checkbox">
                    <span class="checkmark"></span>
                  </label>
                  <label class="container">Freelance
                    <input type="checkbox">
                    <span class="checkmark"></span>
                  </label>
                </div>
                <!-- select-Categories End -->
              </div>
              <!-- single two -->
              <div class="single-listing">
                <div class="small-section-tittle2">
                  <h4>Job Location</h4>
                </div>
                <!-- Select job items start -->
                <div class="select-job-items2">
                  <select name="select">
                    <option value="">Anywhere</option>
                    <option value="">Category 1</option>
                    <option value="">Category 2</option>
                    <option value="">Category 3</option>
                    <option value="">Category 4</option>
                  </select>
                </div>
                <!--  Select job items End-->
                <!-- select-Categories start -->
                <div class="select-Categories pt-80 pb-50">
                  <div class="small-section-tittle2">
                    <h4>Experience</h4>
                  </div>
                  <label class="container">1-2 Years
                    <input type="checkbox">
                    <span class="checkmark"></span>
                  </label>
                  <label class="container">2-3 Years
                    <input type="checkbox" checked="checked active">
                    <span class="checkmark"></span>
                  </label>
                  <label class="container">3-6 Years
                    <input type="checkbox">
                    <span class="checkmark"></span>
                  </label>
                  <label class="container">6-more..
                    <input type="checkbox">
                    <span class="checkmark"></span>
                  </label>
                </div>
                <!-- select-Categories End -->
              </div>
              <!-- single three -->
              <div class="single-listing">
                <!-- select-Categories start -->
                <div class="select-Categories pb-50">
                  <div class="small-section-tittle2">
                    <h4>Posted Within</h4>
                  </div>
                  <label class="container">Any
                    <input type="checkbox">
                    <span class="checkmark"></span>
                  </label>
                  <label class="container">Today
                    <input type="checkbox" checked="checked active">
                    <span class="checkmark"></span>
                  </label>
                  <label class="container">Last 2 days
                    <input type="checkbox">
                    <span class="checkmark"></span>
                  </label>
                  <label class="container">Last 3 days
                    <input type="checkbox">
                    <span class="checkmark"></span>
                  </label>
                  <label class="container">Last 5 days
                    <input type="checkbox">
                    <span class="checkmark"></span>
                  </label>
                  <label class="container">Last 10 days
                    <input type="checkbox">
                    <span class="checkmark"></span>
                  </label>
                </div>
                <!-- select-Categories End -->
              </div>
              <div class="single-listing">
                <!-- Range Slider Start -->
                <aside class="left_widgets p_filter_widgets price_rangs_aside sidebar_box_shadow">
                  <div class="small-section-tittle2">
                    <h4>Filter Jobs</h4>
                  </div>
                  <div class="widgets_inner">
                    <div class="range_item">
                      <!-- <div id="slider-range"></div> -->
                      <input type="text" class="js-range-slider" value="" />
                      <div class="d-flex align-items-center">
                        <div class="price_text">
                          <p>Price :</p>
                        </div>
                        <div class="price_value d-flex justify-content-center">
                          <input type="text" class="js-input-from" id="amount" readonly />
                          <span>to</span>
                          <input type="text" class="js-input-to" id="amount" readonly />
                        </div>
                      </div>
                    </div>
                  </div>
                </aside>
                <!-- Range Slider End -->
              </div>
            </div>
            <!-- Job Category Listing End -->
          </div>
          <!-- Right content -->
          <div class="col-xl-9 col-lg-9 col-md-8">
            <!-- Featured_job_start -->
            <section class="featured-job-area">
              <div class="container">
                <!-- Count of Job list Start -->
                <div class="row">
                  <div class="col-lg-12">
                    <div class="count-job mb-35">
                      <span>39, 782 Jobs found</span>
                      <!-- Select job items start -->
                      <div class="select-job-items">
                        <span>Sort by</span>
                        <select name="select">
                          <option value="">None</option>
                          <option value="">job list</option>
                          <option value="">job list</option>
                          <option value="">job list</option>
                        </select>
                      </div>
                      <!--  Select job items End-->
                    </div>
                  </div>
                </div>
                <!-- Count of Job list End -->

                <?php


                                // Fetch one variation per product (you can adjust the criteria as needed)
                                $sql = "SELECT job_id, job_name, job_price, job_photo, job_duration
                                FROM user_jobs ";

                                $result = $conn->query($sql);

                                // Check if there are products
                                if ($result->num_rows > 0) {
                                    // Begin product container
                                    while ($row = $result->fetch_assoc()) {
                                ?>
                <!-- single-job-content -->
                <div class=" single-job-items mb-30">
                  <div class="job-items">
                    <div class="company-img">
                      <a href="#"><img src="assets/uploads/<?= $row['job_photo'] ?>" alt=""></a>
                    </div>
                    <div class="job-tittle job-tittle2">
                      <a href="#">
                        <h4><?= $row['job_name'] ?></h4>
                      </a>
                      <ul>
                        <li><i class="fas fa-map-marker-alt"></i><?= $row['job_duration'] ?></li>
                        <li>₱<?= $row['job_price'] ?></li>
                      </ul>
                    </div>
                  </div>
                  <div class="items-link items-link2 f-right">
                    <a href="job_details.php">More Info</a>
                  </div>
                </div>

                <?php
                                    }
                                }
                                ?>

              </div>
            </section>
            <!-- Featured_job_end -->
          </div>
        </div>
      </div>
    </div>
    <!-- Job List Area End -->
    <!--Pagination Start  -->
    <div class="pagination-area pb-115 text-center">
      <div class="container">
        <div class="row">
          <div class="col-xl-12">
            <div class="single-wrap d-flex justify-content-center">
              <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-start">
                  <li class="page-item active"><a class="page-link" href="#">01</a></li>
                  <li class="page-item"><a class="page-link" href="#">02</a></li>
                  <li class="page-item"><a class="page-link" href="#">03</a></li>
                  <li class="page-item"><a class="page-link" href="#"><span class="ti-angle-right"></span></a></li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--Pagination End  -->

  </main>
  <footer>
    <!-- Footer Start-->
    <div class="footer-area footer-bg footer-padding">
      <div class="container">
        <div class="row d-flex justify-content-between">
          <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
            <div class="single-footer-caption mb-50">
              <div class="single-footer-caption mb-30">
                <div class="footer-tittle">
                  <h4>About Us</h4>
                  <div class="footer-pera">
                    <p>Freelipino is an exclusive freelancer platform for Filipinos whose talents will cater the local
                      and internatioal demand of the industry. </p>
                  </div>
                </div>
              </div>

            </div>
          </div>
          <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5">
            <div class="single-footer-caption mb-50">
              <div class="footer-tittle">
                <h4>Contact Info</h4>
                <ul>
                  <li>
                    <p>Address : Tandang Sora, Quezon City
                      Philippines </p>
                  </li>
                  <li><a href="#">Phone : +1008 12314561 </a></li>
                  <li><a href="#">Email : info@freelipino.com</a></li>
                </ul>
              </div>

            </div>
          </div>
          <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5">
            <div class="single-footer-caption mb-50">
              <div class="footer-tittle">
                <h4>Important Link</h4>
                <ul>
                  <li><a href="#"> View Project</a></li>
                  <li><a href="#">Contact Us</a></li>
                  <li><a href="#">Testimonial</a></li>
                  <li><a href="#">Properties</a></li>
                  <li><a href="#">Support</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5">
            <div class="single-footer-caption mb-50">
              <div class="footer-tittle">
                <h4>Newsletter</h4>
                <div class="footer-pera footer-pera2">
                  <p>Subscribe to our newsletter to be updated to our latest developments.</p>
                </div>
                <!-- Form -->
                <div class="footer-form">
                  <div id="mc_embed_signup">
                    <form target="_blank"
                      action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01"
                      method="get" class="subscribe_form relative mail_part">
                      <input type="email" name="email" id="newsletter-form-email" placeholder="Email Address"
                        class="placeholder hide-on-focus" onfocus="this.placeholder = ''"
                        onblur="this.placeholder = ' Email Address '">
                      <div class="form-icon">
                        <button type="submit" name="submit" id="newsletter-submit"
                          class="email_icon newsletter-submit button-contactForm"><img src="assets/img/icon/form.png"
                            alt=""></button>
                      </div>
                      <div class="mt-10 info"></div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--  -->
        <div class="row footer-wejed justify-content-between">
          <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
            <!-- logo -->
            <div class="footer-logo mb-20">
              <a href="index.html"><img src="assets/img/logo/logo2_footer.png" alt=""></a>
            </div>
          </div>
          <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5">
            <div class="footer-tittle-bottom">
              <span>5000+</span>
              <p>Talented Hunter</p>
            </div>
          </div>
          <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5">
            <div class="footer-tittle-bottom">
              <span>451</span>
              <p>Talented Hunter</p>
            </div>
          </div>
          <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5">
            <!-- Footer Bottom Tittle -->
            <div class="footer-tittle-bottom">
              <span>568</span>
              <p>Talented Hunter</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- footer-bottom area -->
    <div class="footer-bottom-area footer-bg">
      <div class="container">
        <div class="footer-border">
          <div class="row d-flex justify-content-between align-items-center">
            <div class="col-xl-10 col-lg-10 ">
              <div class="footer-copy-right">
                <p>
                  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                  Copyright &copy;<script>
                  document.write(new Date().getFullYear());
                  </script> All rights reserved. </a>
                  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                </p>
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
    <!-- Footer End-->
  </footer>

  <!-- JS here -->

  <!-- All JS Custom Plugins Link Here here -->
  <script src="./assets/js/vendor/modernizr-3.5.0.min.js"></script>
  <!-- Jquery, Popper, Bootstrap -->
  <script src="./assets/js/vendor/jquery-1.12.4.min.js"></script>
  <script src="./assets/js/popper.min.js"></script>
  <script src="./assets/js/bootstrap.min.js"></script>
  <!-- Jquery Mobile Menu -->
  <script src="./assets/js/jquery.slicknav.min.js"></script>

  <!-- Jquery Slick , Owl-Carousel Range -->
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

  <script>
  function openModal() {
    var modal = document.getElementById("myModal");
    modal.style.display = "block";
  }

  function closeModal() {
    var modal = document.getElementById("myModal");
    modal.style.display = "none";
  }

  // Close the modal when clicking outside of it
  window.onclick = function(event) {
    var modal = document.getElementById("myModal");
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
  </script>



</body>

</html>