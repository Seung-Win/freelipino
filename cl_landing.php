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

require_once 'config.php';

$results_per_page = 6; 
if (!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
}

$start_from = ($page - 1) * $results_per_page;

$sql = "SELECT * FROM user_jobs";
$result = $conn->query($sql);

$user_jobs = [];
if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
        $job_listings[] = $row;
    }
} else {
    echo "0 results";
}


$sql_count = "SELECT COUNT(*) AS total FROM user_jobs";
$result_count = $conn->query($sql_count);
$row_count = $result_count->fetch_assoc();
$total_pages = ceil($row_count['total'] / $results_per_page);


$sql1 = "SELECT COUNT(*) AS total FROM user_jobs WHERE job_category='Technology'";
$result1 = $conn->query($sql1);
$row1 = $result1->fetch_assoc();
$technology = $row1['total'];

$sql2 = "SELECT COUNT(*) AS total FROM user_jobs WHERE job_category='Art'";
$result2 = $conn->query($sql2);
$row2 = $result2->fetch_assoc();
$art = $row2['total'];

$sql3 = "SELECT COUNT(*) AS total FROM user_jobs WHERE job_category='Information Technology'";
$result3 = $conn->query($sql3);
$row3 = $result3->fetch_assoc();
$infotech = $row3['total'];

$sql4 = "SELECT COUNT(*) AS total FROM user_jobs WHERE job_category='Music'";
$result4 = $conn->query($sql4);
$row4 = $result4->fetch_assoc();
$music = $row4['total'];
$conn->close();
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

        .job-listings {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .single-job-items {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #ddd;
            padding: 15px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;

        }

        .company-img {
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .company-img img {
            margin: 0;
            width: 150px;
            height: 150px;
            object-fit: cover;
        }

        .job-tittle {
            margin-top: 15px;
            width: 100%;

        }

        .job-tittle h4 {
            margin: 10px 0;
            font-size: 18px;
            font-weight: bold;
        }

        .job-tittle ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }


        .items-link a {
            display: inline-block;
            margin-top: 10px;
            color: #fff;
            background-color: #007bff;
            padding: 10px 20px;
            border-radius: 3px;
            text-decoration: none;
            font-size: 16px;
            text-align: center;
        }

        .single-job-items p {
            margin: 10px 0;
            font-size: 16px;
        }

        .single-job-items h5 {
            margin: 10px 0;
            font-size: 18px;
            font-weight: bold;
        }

        .single-job-items .details {
            font-size: 14px;
            color: #666;
        }

      
.searchBTN {
    width:100%;
        height:70px;
        background:#fb246a;
        font-size:20px;
        line-height:1;
        text-align:center;
        color:#fff;
        display:block;
        padding:15px;
        border-radius:0px;
        text-transform:capitalize;
        font-family:"Muli",sans-serif;
        letter-spacing:0.1em;
        line-height:1.2;
        line-height:38px;
        font-size:14px
}

    </style>
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
                                <a href="index.html"><img src="assets/img/logo/logo.png" alt=""></a>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9">
                            <div class="menu-wrapper">
                                <div class="main-menu">
                                    <nav class="d-none d-lg-block">
                                        <ul id="navigation">
                                            <li><a href="finding.php">Find Freelancer </a></li>
                                            <li><a href="about.php">About</a></li>
                                        </ul>
                                    </nav>
                                </div>

                                <?php

                                if (isset($_SESSION['email'])) {
                                    echo '<a href="profile.php" style="color: black;">Welcome <span style="color: blue;">' . $_SESSION["first_name"] . '</span>!</a>';
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
                        <!-- Mobile Menu -->
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header End -->
    </header>
    <main>

        <!-- slider Area Start-->
        <div class="slider-area ">
            <!-- Mobile Menu -->
            <div class="slider-active">
                <div class="single-slider slider-height d-flex align-items-center" data-background="assets/img/hero/h1_hero.jpg">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-6 col-lg-9 col-md-10">
                                <div class="hero__caption">
                                    <h1>Find Freelancers that fits to your style</h1>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-8">
                            <form action="finding.php" method="GET" class="search-box">
                    <div class="input-form">
                        <input type="text" name="searchQuery" placeholder="Job Title or keyword" id="searchInput">
                    </div>
                    <div class="search-form">
                    <button type="submit" class="searchBTN">Search</button>
                    </div>
                </form>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- slider Area End-->

        <section class="featured-job-area feature-padding">
            <div class="container">
                <!-- Section Tittle -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-tittle text-center">
                            <span>Recent Job</span>
                            <h2>Featured Jobs</h2>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-xl-10">
                        <!-- single-job-content -->
                        <div class="job-listings">
                            <?php foreach ($job_listings as $job) : ?>
                                <div class="single-job-items mb-30">
                                    <div class="job-items">
                                        <div class="company-img">
                                            <a href="finding.php"><img src="assets/uploads/<?= $job['job_photo'] ?>" alt=""></a>
                                        </div>
                                        <div class="job-tittle">
                                            <a href="finding.php">
                                                <h4><?= $job['job_name'] ?></h4>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="items-link f-right">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="pagination-area mt-50">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">
                                    <?php
                                    for ($i = 1; $i <= $total_pages; $i++) {
                                        echo "<li class='page-item'><a class='page-link' href='index.php?page=$i'>$i</a></li>";
                                    }
                                    ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
        </section>
   

        <!-- Our Services Start -->
        <div class="our-services section-pad-t30">
            <div class="container">
                <!-- Section Tittle -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-tittle text-center">
                            <span>FEATURED TOURS Packages</span>
                            <h2>Browse Top Categories </h2>
                        </div>
                    </div>
                </div>
                <div class="row d-flex justify-contnet-center">
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                        <div class="single-services text-center mb-30">
                            <div class="services-ion">
                                <span class="flaticon-tour"></span>
                            </div>
                            <div class="services-cap">
                                <h5><a href="job_listing.html">Arts</a></h5>
                                <span>(<?php echo $art ?>)</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                        <div class="single-services text-center mb-30">
                            <div class="services-ion">
                                <span class="flaticon-cms"></span>
                            </div>
                            <div class="services-cap">
                                <h5><a href="job_listing.html">Technology</a></h5>
                                <span>(<?php echo $technology ?>)</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                        <div class="single-services text-center mb-30">
                            <div class="services-ion">
                                <span class="flaticon-app"></span>
                            </div>
                            <div class="services-cap">
                                <h5><a href="job_listing.html">Information Technology</a></h5>
                                <span>(<?php echo $infotech ?>)</span>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                        <div class="single-services text-center mb-30">
                            <div class="services-ion">
                                <span class="flaticon-content"></span>
                            </div>
                            <div class="services-cap">
                                <h5><a href="job_listing.html">Music</a></h5>
                                <span>(<?php echo $music ?>)</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- More Btn -->
                <!-- Section Button -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="browse-btn2 text-center mt-50">
                            <a href="finding.php" class="border-btn2">Browse All</a>
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
    <script>
        $(document).ready(function() {
            function loadJobListings() {

                var searchValue = $('#searchInput').val();

                $.ajax({
                    type: "GET",
                    url: "controller/sort_job_controller.php",
                    data: {
                        select4: searchValue
                    },
                    success: function(response) {
                        $('#jobListings').html(response);
                    }
                });
            }
            $('#searchForm').submit(loadJobListings);
        });
        </script>

</body>

</html>