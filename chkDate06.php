<?php
session_start();
	$xGP = $_POST["xGP"];
	$_SESSION["xGP"] = $xGP ;
	// header('location:CyclicProduct.php');
	// require("CyclicProduct.php");
	include 'CyclicProduct.php';
?>