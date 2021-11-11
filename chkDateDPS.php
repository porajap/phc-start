<?php
session_start();
require 'connect.php';

	$xCusCode = $_REQUEST["CusCode"];
	if(  strlen($xCusCode)>1){
		  $_SESSION["CusCode"] = $xCusCode ;
		  header('location:CyclicAll.php?sel=1');
	}else if(  strlen($xCusCode) == 1){
		  $xPv = $_SESSION["xPv"];
		  $xGP = $_SESSION["xGP"];
		  $sYear = $_SESSION["sYear"];
		  $eYear = $_SESSION["eYear"];
		  $xArea = $_SESSION["xArea"];
	}else{
		$xPv = $_POST["xPv"];
		$xGP = $_POST["xGP"];
		$sYear = $_POST["xYear"];
		$eYear = $_POST["xYear2"];			
		$xArea = $_SESSION["xArea"];
		
		$_SESSION["xPv"] = $xPv ;
		$_SESSION["xGP"] = $xGP ;
		$_SESSION["sYear"] = $sYear ;
		$_SESSION["eYear"] = $eYear ;
	}
		
		$SqlX = "SELECT customer.FName,customer.Cus_Code FROM customer " .
				"WHERE customer.AreaCode = '$xArea' " .
				"AND customer.tbCode LIKE '$xPv%' AND customer.IsActive = 1 " .
				"ORDER BY customer.FName ASC";
		// echo "<textarea  rows='10' cols='50' >$SqlX </textarea>";	
	
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
</head>

<style >
	table, th, td {
	   border: 1px solid black;
	} 
</style>

<body>
		<div data-demo-html="true">
			<div data-role="header">
            	<a href="DateDispenser.php" class="ui-btn ui-corner-all ui-btn-inline ui-mini footer-button-left ui-btn-icon-left ui-icon-carat-l">กลับ</a>
            	<h1> <?php echo $Area ?> : <?php echo $xName ?></h1>
				<a href="logoff.php" class="ui-btn-right ui-btn ui-btn-b ui-btn-inline ui-mini ui-corner-all ui-btn-icon-right ui-icon-power">ออก</a>
			</div>
		</div>
        
<ul data-role="listview">
  <li data-role="list-divider"> <H1> ข้อมูลลูกค้า </H1></li>
  <?php
    $Cnt=0;
	$meQuery1 = mysqli_query($conn,$SqlX);
  	while ($Result1 = mysqli_fetch_assoc($meQuery1))
		{	
	?>
    <li><a href="chkDateDPS.php?CusCode=<?php echo $Result1["Cus_Code"]  ?>"><?php echo$sYear?> - <?php echo$eYear?> : <?php echo  $Result1["FName"]  ?></a></li>
  <?php
		}
	?>    
    
</ul>

</body>
</html>