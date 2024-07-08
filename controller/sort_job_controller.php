<?php
require '../config.php';
include '../pagination.php';

// Initialize orderBy with no sorting
$orderBy = "";
$where = "";
$date ="";
$wheresearch = "";

// Check if the sort option is provided as a GET parameter
if (isset($_GET['select'])) { 
    $sortCriterion = $_GET['select'];
    // Determine the SQL ORDER BY clause based on the user's selection
    switch ($sortCriterion) {
        case 'name':
            $orderBy = "ORDER BY job_name";
            break;
        case 'pay':
            $orderBy = "ORDER BY job_price";
            break;
        case 'duration':
            $orderBy = "ORDER BY job_duration";
            break;
        default:
            // No sorting
            break;
    }
}

if (isset($_GET['select2'])) {
    $sortCriterion2 = $_GET['select2'];
    // Determine the SQL ORDER BY clause based on the user's selection
    switch ($sortCriterion2) {
        case 'tech':
            $where = "WHERE job_category='Technology'";
            break;
        case 'art':
            $where = "WHERE job_category='Art'";
            break;
        case 'music':
            $where = "WHERE job_category='Technology'";
            break;
    }
}


if(isset($_GET['select3']) ? $_GET['select3'] : 'any') {
    $dateFilter = $_GET['select3'];
    if ($dateFilter != 'any') {
        $datePrefix = $where == "" ? "WHERE" : "AND"; // Determine if we need WHERE or AND
        switch ($dateFilter) {
            case 'today':
                $date = "$datePrefix DATE(date_added) = CURDATE()";
                break;
            case '2days':
                $date = "$datePrefix date_added >= DATE_SUB(CURDATE(), INTERVAL 2 DAY)";
                break;
            case '3days':
                $date = "$datePrefix date_added >= DATE_SUB(CURDATE(), INTERVAL 3 DAY)";
                break;
            case '5days':
                $date = "$datePrefix date_added >= DATE_SUB(CURDATE(), INTERVAL 5 DAY)";
                break;
            case '10days':
                $date = "$datePrefix date_added >= DATE_SUB(CURDATE(), INTERVAL 10 DAY)";
                break;
            default:
                break;
        }
    }
}

if (isset($_GET['select4'])) {
    $search = $_GET['select4'];
    if ($where == "" && $date == "") {
        $searchPrefix = "WHERE";
    } else {
        $searchPrefix = "AND";
    }
    $wheresearch = "$searchPrefix job_name LIKE '%$search%'";
}


session_start();
if (isset($_SESSION['page_no'])) {
    $page_no = $_SESSION['page_no'];
} else {
    $page_no = 1; // Default to 1 or any default value you prefer
}

$getPaginatedData=getPaginatedData('user_jobs', $where, $date, $wheresearch, $orderBy, $page_no);
extract($getPaginatedData);


if (mysqli_num_rows($result) > 0) {
    // Output the jobs
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class=\"single-job-items mb-30\">";
        echo "<div class=\"job-items\">";
        echo "<div class=\"company-img\">";
        echo "<a href=\"#\"><img src=\"assets/uploads/" . $row['job_photo'] . "\" alt=\"\"></a>";
        echo "</div>";
        echo "<div class=\"job-tittle job-tittle2\">";
        echo "<a href=\"#\">";
        echo "<h4>" . $row['job_name'] . "</h4>";
        echo "</a>";
        echo "<ul>";
        echo "<li><i class=\"fas fa-map-marker-alt\"></i>" . $row['job_duration'] . "</li>";
        echo "<li>₱" . $row['job_price'] . "</li>";
        echo "<li>Posted: " . date('Y-m-d', strtotime($row['date_added'])) . "</li>";
        echo "<li>Category: " . $row['job_category'] . "</li>";
        echo "</ul>";
        echo "</div>";
        echo "</div>";
        echo "<div class=\"items-link items-link2 f-right\">";
        echo '<a href="job_details.php?id=' . $row['job_id'] . '">More Info</a>';
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "No jobs found.";
}

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


