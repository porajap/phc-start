<?php
require 'connect.php';
$xDocNo = $_REQUEST["DocNo"];
$Sql = "UPDATE saleorder SET IsCancel=1 WHERE DocNo = '$xDocNo'";
$meQuery = mysqli_query($conn,$Sql);
	$_SESSION["DocNo"] = "";
	$_SESSION["ItemCode"] = "";
	$_SESSION["Qty"] = "";
	$_SESSION["Price"] = "";
	$_SESSION["Detail"] = "";
header('location:Bill02.php');
?>