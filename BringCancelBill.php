<?php
require 'connect.php';
$xDocNo = $_REQUEST["tDocNo1"];
$Sql = "UPDATE bring SET IsCancel=1 WHERE DocNo = '$xDocNo'";
$meQuery = mysqli_query($conn,$Sql);
	$_SESSION["DocNo"] = "";
	$_SESSION["ItemCode"] = "";
	$_SESSION["Qty"] = "";
	$_SESSION["Price"] = "";
	$_SESSION["Detail"] = "";
header('location:Bring.php');
?>