<?php
$hostName = "localhost";
$dbUser = "root";
$dbPassword = "Cabrera09";
$dbName = "freelipino";

$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);

if (!$conn) {
  die("Could not connect to the database.");
}