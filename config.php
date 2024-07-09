<?php
$hostName = "srv1416.hstgr.io";
$dbUser = "u575758430_Freelancer";
$dbPassword = "Freelipino2024";
$dbName = "u575758430_Freelipino";

$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);

if (!$conn) {
  die("Could not connect to the database.");
}
