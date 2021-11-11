<?php
session_start();
require 'connect.php';
	$xMonth = $_REQUEST["xMonth"];
	$xYear = $_REQUEST["xYear"];

	$Sql = "SELECT sDate,eDate FROM perioddallycall WHERE `Month` = '$xMonth' AND `Year` = '$xYear' ";

	$meQuery = mysqli_query($conn,$Sql);
	while ($Result = mysqli_fetch_assoc($meQuery))
	{
		$sDate	=  $Result["sDate"];
		$eDate	=  $Result["eDate"];
	}
	//$sDate = date("$xYear-$xMonth-1") ;
	//$eDate = date("$xYear2-$xMonth2-t", strtotime("$xYear2-$xMonth2-26"));
	
	$_SESSION["MY1"] = $sDate ;
	$_SESSION["MY2"] = $eDate ;
	
	//$Sql = "UPDATE xdate SET YM = '$ss' WHERE Id = 1";
	//$meQuery = mysqli_query($conn,$Sql);
	echo $Sql;
	echo "<br>";
	echo $sDate . " - " . $eDate;
	//header('location:dailycall02.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Login</title>
	<link rel="shortcut icon" href="favicon.ico">
	<link rel="stylesheet" href="css/themes/default/jquery.mobile-1.4.5.min.css">
	<link rel="stylesheet" href="_assets/css/jqm-demos.css">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
	<script src="js/jquery.js"></script>
	<script src="js/jquery.mobile-1.4.5.min.js"></script>
    <style id="custom-icon">
        .ui-icon-custom:after {
			background-image: url("../_assets/img/glyphish-icons/21-skull.png");
			background-position: 3px 3px;
			background-size: 70%;
		}
    </style>
</head>

<body>
		<div data-demo-html="true">
			<div data-role="header">
            	<h1><?php echo $sDate ?> - <?php echo $eDate ?></h1>
			</div>
		</div>
</body>       