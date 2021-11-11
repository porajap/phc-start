<?php
require 'connect.php';
$xDocNo = $_REQUEST["tDocNo1"];
$Sql = "UPDATE saleorder_sale SET IsCancel=1 WHERE DocNo = '$xDocNo'";
$meQuery = mysqli_query($conn,$Sql);
	$_SESSION["DocNo"] = "";
	$_SESSION["ItemCode"] = "";
	$_SESSION["Qty"] = "";
	$_SESSION["Price"] = "";
	$_SESSION["Detail"] = "";
header('location:Quotation.php');
?>