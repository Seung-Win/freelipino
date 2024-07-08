<?php

function getPaginatedData($table, $where = "", $date = "", $wheresearch="", $orderBy = "", $page_no="")
{
  require 'config.php';

  // Total rows or records to display
  $total_records_per_page = 3;

  // Get the page offset for the LIMIT query
  $offset = ($page_no - 1) * $total_records_per_page;

  // Get previous page
  $previous_page = $page_no - 1;

  // Get the next page
  $next_page = $page_no + 1;

  // Get the total count of records
  $result_count = mysqli_query($conn, "SELECT COUNT(*) as total_records FROM $table") or die(mysqli_error($conn));

  // Total records
  $records = mysqli_fetch_array($result_count);

  // Store total_records to a variable
  $total_records = $records['total_records'];

  // Get total pages
  $total_no_of_pages = ceil($total_records / $total_records_per_page);

  // Query string if and elseif
  if ($table === 'user_jobs') {
    $sql = "SELECT * FROM $table $where $date $wheresearch $orderBy";;
  } 

  $sql .= " LIMIT $offset , $total_records_per_page";

  // Result
  $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

  // Return the value to the main php
  return [
    'result' => $result,
    'page_no' => $page_no,
    'previous_page' => $previous_page,
    'next_page' => $next_page,
    'total_no_of_pages' => $total_no_of_pages,
  ];
}
