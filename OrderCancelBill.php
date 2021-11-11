<?php
session_start();
require 'connect.php';
	$xDocNo = $_POST["tDocNo1"];
	$Sql = "DELETE FROM saleorder WHERE DocNo = '$xDocNo'";
	$meQuery = mysqli_query($conn,$Sql);
	$Sql = "DELETE FROM saleorder_detail WHERE DocNo = '$xDocNo'";
	$meQuery = mysqli_query($conn,$Sql);

	$_SESSION["DocNo"] = "";
	$_SESSION["ItemCode"] = "";
	$_SESSION["Qty"] = "";
	$_SESSION["Price"] = "";
	$_SESSION["Detail"] = "";
	header('location:order.php');
?>