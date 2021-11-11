<?php
session_start();
	if($_SESSION["Area"] == "") header('location:index.html');
	$Area = $_SESSION["Area"];
	
require 'connect.php';
$Hospital = $_POST["Hospital"];

$Sql = "INSERT INTO hospital ";
$Sql .= "(Hospital_Name,Hospital_Area)";
$Sql .= " VALUES ";
$Sql .= "('$Hospital','$Area')";
$meQuery = mysqli_query($conn,$Sql);
header('location:ListHospital.php');
?>
<body>
<textarea  rows='10' cols='50' ><?php echo $Sql ?></textarea>
</body>