<?php
session_start();
		$sDate = $_SESSION["sDate"];
		$eDate = $_SESSION["eDate"];
		echo $sDate . " : " . $eDate;
?>
