<?php
$hostName = "sql12.freemysqlhosting.net";
$dbUser = "sql12717505";
$dbPassword = "Av4z8293rv";
$dbName = "sql12717505";

$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);

if (!$conn) {
  die("Could not connect to the database.");
}
