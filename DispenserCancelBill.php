<?php
require 'connect.php';
$xDocNo = $_POST["tDocNo1"];
$Sql = "UPDATE br_dispenser SET IsCancel=1 WHERE DocNo = '$xDocNo'";
$meQuery = mysqli_query($conn,$Sql);
	$_SESSION["DocNo"] = "";
	$_SESSION["ItemCode"] = "";
	$_SESSION["Qty"] = "";
	$_SESSION["Price"] = "";
	$_SESSION["Detail"] = "";
header('location:Dispenser.php');
?>