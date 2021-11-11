<?php
session_start();
	$xPv = $_POST["xPv"];
	$xGP = $_POST["xGP"];
	$sYear = $_POST["xYear"];
	$eYear = $_POST["xYear2"];
	
	$_SESSION["xPv"] = $xPv ;
	$_SESSION["xGP"] = $xGP ;
	$_SESSION["sYear"] = $sYear ;
	$_SESSION["eYear"] = $eYear ;

	header('location:Cyclic.php');
?>