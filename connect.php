<?php
/*
 * set var
 */
// $cfHost = "poseintelligence.dyndns.biz:3308";
$cfHost = "localhost";
$cfUser = "root";
$cfPassword = "A$192dijd";
$cfDatabase = "phc";

/*
 * connection mysql
 */

$conn = mysqli_connect($cfHost, $cfUser, $cfPassword,$cfDatabase);
// Check connection
if (mysqli_connect_errno()){
  // echo "Failed to connect to MySQL: " . mysqli_connect_error();
  echo "Error: Unable to connect to MySQL." . PHP_EOL;
  echo "<br />Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
  echo "<br />Debugging error: " . mysqli_connect_error() . PHP_EOL;
  exit;
}

mysqli_set_charset($conn, "utf8");
set_time_limit(0);
ini_set('mysql.connect_timeout','0');
ini_set('max_execution_time', '0');
?>
