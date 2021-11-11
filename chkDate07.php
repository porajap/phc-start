<?php
session_start();
require 'connect.php';
		$xYear = $_POST["xYear07"];
		$xMonth = $_POST["xMonth07"];
		
		$_SESSION["xYear07"] = $xYear ;
		$_SESSION["xMonth07"] = $xMonth ;
		
	header('location:Summarize.php');
?>
